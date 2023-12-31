<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'vehicle_id',
        'driver_id',
        'status',
        'approvals',
        'departure_office',
        'departure_latitude',
        'departure_longitude',
        'destination_office',
        'destination_latitude',
        'destination_longitude',
        'distance',
        'note',
        'current_approval',
        'work_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function  departure(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'departure_office');
    }

    public function  destination(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'destination_office');
    }
}
