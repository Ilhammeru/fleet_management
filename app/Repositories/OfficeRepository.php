<?php

namespace App\Repositories;

use App\Repositories\Interface\OfficeInterface;
use App\Models\Office;

class OfficeRepository extends OfficeInterface {
    private $Office;

    public function __construct()
    {
        $this->Office = new Office;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->Office->query();
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
        $query = $this->Office->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function store(array $data)
    {
        return $this->Office->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->Office->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->Office->where('id', $id)
            ->delete();
    }
}
