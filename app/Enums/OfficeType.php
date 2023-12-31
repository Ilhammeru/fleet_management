<?php

namespace App\Enums;

enum OfficeType: int
{
    case Office = 1;
    case Branch = 2;
    case Mine = 3;

    public function label()
    {
        return match ($this) {
            static::Office => __('global.office'),
            static::Branch => __('global.branch'),
            static::Mine => __('global.mine'),
        };
    }
}
