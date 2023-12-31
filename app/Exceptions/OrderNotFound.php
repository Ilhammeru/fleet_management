<?php

namespace App\Exceptions;

use Exception;

class OrderNotFound extends Exception
{
    public function render($request)
    {
        return apiResponse([
            'error' => true,
            'message' => $this->getMessage(),
        ]);
    }
}
