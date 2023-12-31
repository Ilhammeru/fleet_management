<?php

namespace App\Repositories;

use App\Repositories\Interface\VehicleModelInterface;
use App\Models\VehicleModel;

class VehicleModelRepository extends VehicleModelInterface {
    private $VehicleModel;

    public function __construct()
    {
        $this->VehicleModel = new VehicleModel;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->VehicleModel->query();
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
        $query = $this->VehicleModel->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function store(array $data)
    {
        return $this->VehicleModel->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->VehicleModel->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->VehicleModel->where('id', $id)
            ->delete();
    }
}
