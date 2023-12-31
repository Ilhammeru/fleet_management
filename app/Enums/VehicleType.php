<?php

namespace App\Enums;

enum VehicleType: int
{
    case FreightTransportation = 1;
    case PeopleTransportation = 2;

    public function label()
    {
        return match ($this) {
            static::FreightTransportation => __("global.freightTransportation"),
            static::PeopleTransportation => __("global.peopleTransportation"),
        };
    }
}
