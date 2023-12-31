<?php

namespace App\Services;

use App\Enums\OfficeType;
use App\Repositories\OfficeRepository;

class OfficeService {
    private $repo;

    public function __construct()
    {
        $this->repo = new OfficeRepository;
    }

    /**
    * Function to get list of data
    */
    public function list(): array
    {
        $select = 'id,name,address,province_id,city_id,district_id,village_id,latitude,longitude,office_type';

        $where = null;
        if (request()->office_type) {
            $where = 'office_type = ' . request()->office_type;
        }

        $relation = ['province:id,name', 'district:id,name', 'city:id,name', 'village:id,name'];

        $data = $this->repo->list($select, $where, $relation);

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $data,
        ];
    }

    /**
    * Function to get list of data
    */
    public function getAvailableTypes(): array
    {
        $cases = OfficeType::cases();

        $out = [];
        foreach ($cases as $case) {
            $out[] = [
                'id' => $case,
                'text' => $case->label(),
            ];
        }

        return [
            'error' => false,
            'message' => 'Success',
            'data' => $out,
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
