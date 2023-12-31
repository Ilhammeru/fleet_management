<?php

namespace App\Enums;

enum VehicleOwnership: int
{
    case Owned = 1;
    case Rent = 2;

    public function label()
    {
        return match ($this) {
            static::Owned => __("global.owned"),
            static::Rent => __("global.rent"),
        };
    }
}
