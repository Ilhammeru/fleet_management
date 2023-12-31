<?php

namespace App\Repositories;

use App\Repositories\Interface\VehicleTypeInterface;
use App\Models\VehicleType;

class VehicleTypeRepository extends VehicleTypeInterface {
    private $VehicleType;

    public function __construct()
    {
        $this->VehicleType = new VehicleType;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->VehicleType->query();
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
        $query = $this->VehicleType->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function store(array $data)
    {
        return $this->VehicleType->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->VehicleType->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->VehicleType->where('id', $id)
            ->delete();
    }
}
