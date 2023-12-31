<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserWorkStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'current_vehicle',
        'driving_license_number',
        'driving_license_due',
        'image',
        'work_status',
        'user_type',
    ];

    protected $appends = ['is_idle'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'work_status' => UserWorkStatus::class,
    ];

    public function isIdle(): Attribute
    {
        $out = false;

        if ((isset($this->attributes['work_status'])) && ($this->attributes['work_status'] == UserWorkStatus::Idle->value)) {
            $out = true;
        }

        return Attribute::make(
            get: fn() => $out,
        );
    }
}
