<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiResponse($this->userService->listDriver());
    }

    public function statuses()
    {
        return apiResponse([
            'error' => false,
            'message' => 'Success',
            'data' => $this->userService->getDriverStatuses(),
        ]);
    }

    public function getReadyJob()
    {
        return apiResponse($this->userService->getReadyJob());
    }

    public function startWork(Request $request)
    {
        return apiResponse($this->userService->startWork($request->toArray()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
