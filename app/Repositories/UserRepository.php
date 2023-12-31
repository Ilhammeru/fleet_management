<?php

namespace App\Repositories;

use App\Repositories\Interface\UserInterface;
use App\Models\User;

class UserRepository extends UserInterface {
    private $User;

    public function __construct()
    {
        $this->User = new User;
    }

    public function list(string $select = '*', $where = null, $relation = null)
    {
        $query = $this->User->query();
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
        $query = $this->User->query();
        $query->selectRaw($select);

        if ($relation) {
            $query->with($relation);
        }

        return $query->find($id);
    }

    public function detailWithCondition(string $select = '*', $where = null)
    {
        $query = $this->User->query();
        $query->selectRaw($select);

        if ($where) {
            $query->whereRaw($where);
        }

        return $query->first();
    }

    public function store(array $data)
    {
        return $this->User->create($data);
    }

    public function update(array $data, string|int $id)
    {
        return $this->User->where('id', $id)
            ->update($data);
    }

    public function delete(array|string $id)
    {
        return $this->User->where('id', $id)
            ->delete();
    }
}
