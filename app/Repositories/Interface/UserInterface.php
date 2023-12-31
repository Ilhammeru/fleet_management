<?php

namespace App\Repositories\Interface;

abstract class UserInterface {
    abstract function list(string $select = '*', $where = null, $relation = null);

    abstract function show(string|int $id, string $select = '*', $relation = null);

    abstract function detailWithCondition(string $select = '*', $where = null);

    abstract function store(array $data);

    abstract function update(array $data, string|int $id);

    abstract function delete(array|string $id);
}
