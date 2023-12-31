<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CredentialMissmatch;
use App\Exceptions\PasswordNotMatch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Login $request)
    {
        try {
            $user = $this->userService->detailWithCondition(
                '*',
                "email = '" . $request->email . "'"
            );

            if (!$user)
                throw new CredentialMissmatch(__('global.userNotFound'));

            if (!Hash::check($request->password, $user->password))
                throw new PasswordNotMatch(__("global.passwordWrong"));

            $userId = $user->id;

            $permissions = $user->getAllPermissions();
            $permissions = collect($permissions)->pluck('name')->all();

            $token = $user->createToken("user{$userId}-token", $permissions);

            return apiResponse([
                'error' => false,
                'message' => 'Success',
                'data' => [
                    'token' => $token->plainTextToken,
                ]
            ]);
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => generateErrorMessage($th),
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
