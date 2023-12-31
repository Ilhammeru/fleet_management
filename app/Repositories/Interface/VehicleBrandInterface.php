<?php

namespace App\Repositories\Interface;

abstract class VehicleBrandInterface {
    abstract function list(string $select = '*', $where = null, $relation = null);

    abstract function show(string|int $id, string $select = '*', $relation = null);

    abstract function store(array $data);

    abstract function update(array $data, string|int $id);

    abstract function delete(array|string $id);
}