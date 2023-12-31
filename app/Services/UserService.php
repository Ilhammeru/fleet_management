<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\UserType;
use App\Enums\UserWorkStatus;
use App\Exceptions\OrderNotFound;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;

class UserService {
    private $repo;
    private $orderRepo;

    public function __construct()
    {
        $this->repo = new UserRepository;
        $this->orderRepo = new OrderRepository;
    }

    /**
    * Function to get list of data
    */
    public function list(): array
    {
        $select = 'id,name,email,image,driving_license_number,driving_license_due,phone,work_status';

        $where = null;
        if (request()->status) {
            $where = 'work_status = ' . request()->status;
        }

        $data = $this->repo->list($select, $where);

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    /**
    * Function to get list of data
    */
    public function listDriver(): array
    {
        $select = 'id,name,email,image,driving_license_number,driving_license_due,phone,work_status';

        $where = "user_type = '" . UserType::Driver->value . "'";
        if (request()->status) {
            $where = ' and work_status = ' . request()->status;
        }

        $data = $this->repo->list($select, $where);

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    public function listApprovals()
    {
        $select = 'id,name,email,image,driving_license_number,driving_license_due,phone,work_status';

        $where = "user_type = '" . UserType::Approval->value . "'";

        $data = $this->repo->list($select, $where);

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    public function getReadyJob()
    {
        $select = 'order_id,vehicle_id,driver_id,status,approvals,departure_office,departure_latitude,departure_longitude,destination_office,destination_latitude,destination_longitude,distance';

        $relation = [
            'vehicle:id,vehicle_model_id,vehicle_brand_id,license_plate,fuel_consumption', 'vehicle.brand:id,name', 'vehicle.model:id,name',
            'destination:id,name,address', 'departure:id,name,address'
        ];
        $data = $this->orderRepo->list(
            $select,
            "driver_id = " . auth()->id() . " and status = " . OrderStatus::Approved->value,
            $relation
        );

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    public function getJobs($userId)
    {
        $where = "json_contains(approvals, '{$userId}')";
        if (request()->status > 0 && request()->status == 2) {
            $where .= " and current_approval = " . $userId;
        }

        $select = 'order_id,vehicle_id,driver_id,status,approvals,departure_office,departure_latitude,departure_longitude,destination_office,destination_latitude,destination_longitude,distance';

        $relation = [
            'vehicle:id,vehicle_model_id,vehicle_brand_id,license_plate,fuel_consumption', 'vehicle.brand:id,name', 'vehicle.model:id,name',
            'destination:id,name,address', 'departure:id,name,address'
        ];

        $data = $this->orderRepo->list($select, $where, $relation);

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    public function startWork(array $data)
    {
        try {
            $order = $this->orderRepo->detailWithCondition(
                '*',
                "order_id = '" . $data['order_id'] . "'",
                ['vehicle:id,vehicle_brand_id,vehicle_model_id,license_plate', 'vehicle.brand:id,name', 'vehicle.model:id,name']
            );

            if (!$order) {
                throw new OrderNotFound(__("global.orderNotFound"));
            }

            // change to approved
            $this->orderRepo->update([
                'status' => OrderStatus::Approved->value,
            ], $order->id);

            // change driver to onduty
            $this->repo->update([
                'work_status' => UserWorkStatus::OnDuty->value,
                'current_vehicle' => json_encode([
                    'id' => $order->vehicle->id,
                    'license_plate' => $order->vehicle->license_plate,
                    'model' => $order->vehicle->model->name,
                    'brand' => $order->vehicle->brand->name,
                ])
            ], auth()->id());

            return [
                'error' => false,
                'message' => __('global.orderOnTheWay'),
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }

    public function getIdleDriver()
    {
        return $this->repo->list(
            'id,name,email',
            'work_status = ' . UserWorkStatus::Idle->value,
        );
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
    * Function to get detail data
    *
    * @var string|int $id
    */
    public function detailWithCondition($select = '*', $where = null)
    {
        return $this->repo->detailWithCondition($select, $where);
    }

    public function getDriverStatuses()
    {
        $cases = UserWorkStatus::cases();
        $out = [];
        foreach ($cases as $case) {
            $out[] = [
                'id' => $case,
                'text' => $case->label(),
            ];
        }

        return [
            'error' => false,
            'mesasge' => 'Success',
            'data' => $out,
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
            return [
                'error' => false,
                'message' => 'Success',
                'data' => $this->repo->store($data),
            ];
        } catch(\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
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
