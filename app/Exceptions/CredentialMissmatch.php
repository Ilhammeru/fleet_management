<?php

namespace App\Exceptions;

use Exception;

class CredentialMissmatch extends Exception
{
    public function render($request)
    {
        return apiResponse([
            'error' => true,
            'message' => $this->getMessage(),
        ]);
    }
}
