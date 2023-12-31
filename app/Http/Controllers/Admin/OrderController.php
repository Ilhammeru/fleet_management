<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VehicleStatus;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Http\Requests\Order\Create;
use App\Http\Requests\Order\Update;
use App\Services\UserService;
use App\Services\VehicleService;

class OrderController extends Controller
{
    private $service;
    private $vehicleService;
    private $userService;

    public function __construct()
    {
        $this->service = new OrderService;
        $this->vehicleService = new VehicleService;
        $this->userService = new UserService;
    }

    /**
    * Function to show page
    *
    * @return \Illuminate\Contracts\View\View
    */
    public function index()
    {
        return view('orders.index');
    }

    /**
    * Function to show create page
    *
    * @return \Illuminate\Contracts\View\View
    */
    public function create()
    {
        $vehicles = $this->vehicleService->list(
            'id,vehicle_brand_id,vehicle_model_id,license_plate',
            'status = ' . VehicleStatus::Idle->value,
            ['brand:id,name', 'model:id,name']
        );
        $vehicles = collect($vehicles['data'])->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->brand->name . ' - ' . $item->model->name . ' ('. $item->license_plate .')',
            ];
        })->all();

        $drivers = $this->userService->getIdleDriver();
        if (count($drivers) > 0) {
            $drivers = collect($drivers)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name,
                ];
            })->all();
        }

        $forms = [
            [
                'name' => 'vehicle',
                'label' => __('global.selectVehicle'),
                'fieldType' => 'select',
                'selectOptions' => $vehicles,
                'formModel' => 'classic-inline',
                'isRequired' => true,
            ],
            [
                'name' => 'driver',
                'label' => __('global.selectDriver'),
                'fieldType' => 'select',
                'selectOptions' => $drivers,
                'formModel' => 'classic-inline',
                'isRequired' => true,
            ],
        ];

        return view('orders.create', compact('forms'));
    }

    /**
    * Function to store data
    *
    * @return \Illuminate\Http\Response
    */
    public function store(Create $request)
    {
        return apiResponse($this->service->store($request->validated()));
    }

    /**
    * Function to update data
    *
    * @var string|int $id
    *
    * @return \Illuminate\Http\Response
    */
    public function update(Update $request, $id)
    {
        return apiResponse($this->service->update($request->validated(), $id));
    }

    /**
    * Function to delete data
    *
    * @var string|int $id
    *
    * @return \Illuminate\Http\Response
    */
    public function destroy(string|int $id)
    {
        return apiResponse($this->service->delete($id));
    }
}
