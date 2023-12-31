<?php

namespace App\Repositories;

use App\Repositories\Interface\VehicleBrandInterface;
use App\Models\VehicleBrand;

class VehicleBrandRepository extends VehicleBrandInterface {
    private $VehicleBrand;

    public function __construct()
    {
        $this->VehicleBrand = new VehicleBrand;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->VehicleBrand->query();
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
        $query = $this->VehicleBrand->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function store(array $data)
    {
        return $this->VehicleBrand->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->VehicleBrand->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->VehicleBrand->where('id', $id)
            ->delete();
    }
}
