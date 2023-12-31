<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new AuthenticationService;
    }

    public function login()
    {
        $forms = [
            [
                'name' => 'email',
                'label' => __('global.email'),
                'inputType' => 'email',
                'isRequired' => true,
                'placeholder' => 'john@doe.com',
                'formModel' => 'modern',
                'inputDescription' => __('global.yourUniqueEmail'),
            ],
            [
                'name' => 'password',
                'label' => __('global.password'),
                'inputType' => 'password',
                'isRequired' => true,
                'placeholder' => __('global.secretWord'),
                'formModel' => 'modern',
                'inputDescription' => __('global.secretWord')
            ],
        ];

        return view('auth.login', compact('forms'));
    }

    public function doLogin(Login $request)
    {
        $login = $this->service->login($request->validated());

        if (!$login['error']) {
            $request->session()->regenerate();
        }

        return apiResponse($login);
    }
}
