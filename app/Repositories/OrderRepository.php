<?php

namespace App\Repositories;

use App\Repositories\Interface\OrderInterface;
use App\Models\Order;

class OrderRepository extends OrderInterface {
    private $Order;

    public function __construct()
    {
        $this->Order = new Order;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->Order->query();
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
        $query = $this->Order->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function detailWithCondition(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->Order->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        if ($where) {
            $query->whereRaw($where);
        }

        return $query->first();
    }

    public function store(array $data)
    {
        return $this->Order->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->Order->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->Order->where('id', $id)
            ->delete();
    }
}
