<?php

use Illuminate\Contracts\Validation\Validator;

if (!function_exists('apiResponse')) {
    function apiResponse($payload)
    {
        $code = 201;
        $error = false;
        if ($payload['error'])
            $code = 500;
            $error = $payload['error'];

        if (isset($payload['code']))
            $code = $payload['code'];

        return response()->json([
            'error' => $error,
            'message' => $payload['message'],
            'data' => isset($payload['data']) ? $payload['data'] : [],
        ], $code);
    }
}

if (!function_exists('generateErrorMessage')) {
    function generateErrorMessage($th)
    {
        $out = 'Error: ' . $th->getMessage() . ', at ' . $th->getLine() . '. Please check ' . $th->getFile();

        if (env('APP_ENV') == 'production')
            $out = __('global.cannotProcessData');

        if (get_class($th) != $th->getMessage())
            $out = $th->getMessage();

        return $out;
    }
}

if (!function_exists('formRequestResponseHelper')) {
    function formRequestResponseHelper(Validator $validator) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Please fill all required field',
            'code' => 422,
        ], 422);
    }
}

if (!function_exists('haversineAlgo')) {
    function haversineMethod($latitude_from, $longitude_from, $latitude_to, $longitude_to, $earth_radius = 6371000)
    {
        $radius = 6371; // Earth's radius in kilometers

        // Calculate the differences in latitude and longitude
        $delta_lat = $latitude_to - $latitude_from;
        $delta_lon = $longitude_to - $longitude_from;

        // Calculate the central angles between the two points
        $alpha = $delta_lat / 2;
        $beta = $delta_lon / 2;

        // Use the Haversine formula to calculate the distance
        $a = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($latitude_from)) * cos(deg2rad($latitude_to)) * sin(deg2rad($beta)) * sin(deg2rad($beta));
        $c = asin(min(1, sqrt($a)));
        $distance = 2 * $radius * $c;

        // Round the distance to four decimal places
        $distance = round($distance, 4);

        return $distance;
    }
}

if (!function_exists('generateOrderId')) {
    function generateOrderId($number, $len) {
        return str_pad($number, $len, '0', STR_PAD_LEFT);
    }
}
