<?php

namespace App\Enums;

enum OrderStatus: int
{
    case WaitingApproval = 1;
    case FirstLevelApproval = 2;
    case FinalApproval = 3;
    case Approved = 4;
    case Finished = 5;

    public function label()
    {
        return match ($this) {
            static::WaitingApproval => __('global.waitingApproval'),
            static::FirstLevelApproval => __('global.firstLevelApproval'),
            static::FinalApproval => __('global.finalApproval'),
            static::Approved => __('global.approved'),
            static::Finished => __('global.finished'),
        };
    }
}
