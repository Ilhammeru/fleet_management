<?php

namespace App\Enums;

enum UserType: int
{
    case Admin = 1;
    case Driver = 2;
    case Approval = 3;

    public function label()
    {
        return match ($this) {
            static::Admin => __("global.admin"),
            static::Driver => __("global.drivers"),
            static::Approval => __("global.approval"),
        };
    }
}
