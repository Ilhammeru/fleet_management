<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Order\Create;
use App\Services\OrderService;

class OrderController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new OrderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiResponse($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        return apiResponse($this->service->store($request->validated()));
    }

    public function statuses()
    {
        return apiResponse($this->service->getStatuses());
    }

    public function approve(Request $request)
    {
        return $this->service->approve($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
