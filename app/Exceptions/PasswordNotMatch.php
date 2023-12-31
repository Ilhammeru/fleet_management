<?php

namespace App\Exceptions;

use Exception;

class PasswordNotMatch extends Exception
{
    public function render($request)
    {
        return apiResponse([
            'error' => true,
            'message' => $this->getMessage(),
        ]);
    }
}
