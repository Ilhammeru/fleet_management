<?php

namespace App\Services;

use App\Repositories\VehicleRepository;

class VehicleService {
    private $repo;

    public function __construct()
    {
        $this->repo = new VehicleRepository;
    }

    /**
    * Function to get list of data
    */
    public function list(string $select = '*', $where = null, $relation = null): array
    {
        return [
            'error' => false,
            'message' => 'Success',
            'data' => $this->repo->list($select, $where, $relation),
        ];
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
