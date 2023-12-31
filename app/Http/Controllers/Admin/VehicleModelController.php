<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VehicleModelService;
use App\Http\Requests\VehicleModel\Create;
use App\Http\Requests\VehicleModel\Update;

class VehicleModelController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new VehicleModelService;
    }

    /**
    * Function to show page
    *
    * @return \Illuminate\Contracts\View\View
    */
    public function index()
    {
        //
    }

    /**
    * Function to show create page
    *
    * @return \Illuminate\Contracts\View\View
    */
    public function create()
    {
        //
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
