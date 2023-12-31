<?php

namespace App\Enums;

enum VehicleStatus: int
{
    case Idle = 1;
    case OnDuty = 2;
    case OnService = 3;

    public function label()
    {
        return match ($this) {
            static::Idle => __("global.idle"),
            static::OnDuty => __("global.onDuty"),
            static::OnService => __("global.onService"),
        };
    }
}
