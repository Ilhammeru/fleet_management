<?php

namespace App\Enums;

enum UserWorkStatus: int
{
    case Idle = 1;
    case OnDuty = 2;

    public function label()
    {
        return match ($this) {
            static::Idle => __("global.idle"),
            static::OnDuty => __("global.onDuty"),
        };
    }
}
