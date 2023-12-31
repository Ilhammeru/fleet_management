<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\UserWorkStatus;
use App\Enums\VehicleStatus;
use App\Exceptions\DriverNotAvailable;
use App\Exceptions\OrderNotFound;
use App\Exceptions\WrongApprovalPath;
use App\Repositories\OfficeRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\Auth;

class OrderService {
    private $repo;
    private $officeRepo;
    private $driverRepo;
    private $vehicleRepo;

    public function __construct()
    {
        $this->repo = new OrderRepository;
        $this->officeRepo = new OfficeRepository;
        $this->driverRepo = new UserRepository;
        $this->vehicleRepo = new VehicleRepository;
    }

    /**
    * Function to get list of data
    */
    public function list(): array
    {
        $select = 'order_id,vehicle_id,driver_id,status,approvals,departure_office,departure_latitude,departure_longitude,destination_office,destination_latitude,destination_longitude,distance';

        $relation = [
            'vehicle:id,vehicle_model_id,vehicle_brand_id,license_plate,fuel_consumption', 'vehicle.brand:id,name', 'vehicle.model:id,name',
            'destination:id,name,address', 'departure:id,name,address'
        ];

        $where = null;
        if (request()->status) {
            $where = 'status = ' . request()->status;
        }

        if (Auth::user()->hasRole('driver')) {
            $where = 'status IN ('. OrderStatus::Approved->value .', '. OrderStatus::Finished->value .')';
        }

        $data = $this->repo->list($select, $where, $relation);

        $data = collect($data)->map(function ($item) {
            $item['estimate_fuel_consumption'] = 0;

            $kmPerLiter = $item->vehicle->fuel_consumption;
            $fuelPerKm = 1 / $kmPerLiter;
            $distance = $item->distance;
            $item['estimate_fuel_consumption'] = ceil($fuelPerKm * $distance) . ' Ltr';

            $item['status_text'] = null;
            $cases = OrderStatus::cases();
            for ($a = 0; $a < count($cases); $a++) {
                if ($cases[$a] == $item->status) {
                    $item['status_text'] = $cases[$a]->label();
                }
            }

            return $item;
        })->all();

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    public function approve(array $data)
    {
        try {
            $order = $this->repo->detailWithCondition('*', "order_id = '" . $data['order_id'] . "'");

            if (!$order) {
                throw new OrderNotFound(__("global.orderNotFound"));
            }

            $approvals = json_decode($order->approvals, true);
            $approvalPosition = array_search(auth()->id(), $approvals);

            if ($order->current_approval != auth()->id() && $approvalPosition == 0) {
                throw new WrongApprovalPath(__('global.alreadyApproveByApproval'));
            } elseif ($order->current_approval != auth()->id() && $approvalPosition == 1) {
                throw new WrongApprovalPath(__('global.needFirstApproval'));
            }

            $payload = [];
            if ($approvalPosition == 0) {
                $payload['current_approval'] = $approvals[1];
                $payload['status'] = OrderStatus::FirstLevelApproval->value;
            } else if ($approvalPosition == 1) {
                $payload['current_approval'] = null;
                $payload['status'] = OrderStatus::FinalApproval->value;

                // assign vehicle on service
                $this->vehicleRepo->update([
                    'status' => VehicleStatus::OnDuty->value,
                ], $order->vehicle_id);
            }

            $this->repo->update($payload, $order->id);

            return [
                'error' => false,
                'message' => __('global.successApproveOrder'),
                'data' => $order,
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }

    /**
    * Function to get detail data
    *
    * @var string|int $id
    */
    public function detail(string|int $id): array
    {
        return [
            'error' => false,
            'message' => 'Success',
            'data' => $this->repo->show($id),
        ];
    }

    /**
    * Function to get store data
    *
    * @var array $data
    */
    public function store(array $data): array
    {
        try {
            // validate driver
            $checkDriver = $this->repo->list(
                'id,status',
                'status != ' . OrderStatus::Finished->value . " and work_date = '" . $data['date'] . "' and vehicle_id = " . $data['vehicle_id']
            );
            if (count($checkDriver) > 0) {
                throw new DriverNotAvailable(__('global.driverNotAvailable'));
            }

            // get distance
            $departure = $this->officeRepo->show($data['departure_id'], 'latitude,longitude');
            $destination = $this->officeRepo->show($data['destination_id'], 'latitude,longitude');
            $distance = haversineMethod($departure->latitude, $departure->longitude, $destination->latitude, $destination->longitude);

            $latestOrder = $this->repo->list('id');
            $nextOrder = count($latestOrder) + 1;

            $payload = collect($data)->merge([
                'order_id' => 'OR-' . generateOrderId($nextOrder, 10),
                'distance' => $distance,
                'departure_latitude' => $departure->latitude,
                'departure_longitude' => $departure->longitude,
                'destination_latitude' => $destination->latitude,
                'destination_longitude' => $destination->longitude,
                'destination_office' => $data['destination_id'],
                'departure_office' => $data['departure_id'],
                'status' => OrderStatus::WaitingApproval->value,
                'work_date' => $data['date']
            ])
                ->except(['departure_id', 'destination_id'])
                ->toArray();

            $payload['approvals'] = json_encode($data['approvals']);
            $payload['current_approval'] = $data['approvals'][0];

            $this->repo->store($payload);

            return [
                'error' => false,
                'message' => __('global.order_success'),
                'data' => $payload,
            ];
        } catch(\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }

    public function getStatuses()
    {
        $cases = OrderStatus::cases();

        $out = [];
        foreach ($cases as $case) {
            $out[] = [
                'id' => $case,
                'text' => $case->label(),
            ];
        }

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $out,
        ];
    }

    /**
    * Function to update current data
    *
    * @var array $data
    *
    * @var string|int $id
    */
    public function update(array $data, string|int $id): array
    {
        try {
            return [
                'error' => false,
                'message' => 'Success',
                'data' => $this->repo->update($data, $id),
            ];
        } catch(\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }

    /**
    * Function to delete selected data
    *
    * @var array|string $id
    */
    public function delete(array|string $id): array
    {
        try {
            return [
                'error' => false,
                'message' => 'Success',
                'data' => $this->repo->delete($id),
            ];
        } catch(\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }
}
