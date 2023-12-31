<?php

namespace App\Repositories;

use App\Repositories\Interface\VehicleInterface;
use App\Models\Vehicle;

class VehicleRepository extends VehicleInterface {
    private $Vehicle;

    public function __construct()
    {
        $this->Vehicle = new Vehicle;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->Vehicle->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        if ($where) {
            $query->whereRaw($where);
        }

        return $query->get();
    }

    public function show(string|int $id, string $select = '*', $relation = null)
    {
        $query = $this->Vehicle->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function store(array $data)
    {
        return $this->Vehicle->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->Vehicle->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->Vehicle->where('id', $id)
            ->delete();
    }
}
