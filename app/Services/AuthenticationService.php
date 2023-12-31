<?php

namespace App\Services;

use App\Exceptions\CredentialMissmatch;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class AuthenticationService {
    private $repo;

    public function __construct()
    {
        $this->repo = new UserRepository;
    }

    /**
    * Function to get list of data
    */
    public function list(): array
    {
        return [
            'error' => false,
            'message' => 'Success',
            'data' => $this->repo->list(),
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

    public function login(array $data)
    {
        try {
            $attempt = Auth::attempt($data);
            if (!$attempt)
                throw new CredentialMissmatch(__('global.userNotFound'));

            return [
                'error' => false,
                'message' => __("global.successLogin"),
                'data' => [
                    'url' => route('dashboard'),
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
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
