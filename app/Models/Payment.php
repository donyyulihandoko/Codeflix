<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
// use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'plan_id',
        'transaction_number',
        'total_amount',
        'status',
        'midtrans_snap_token',
        'payment_type',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];


    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Payment has been {$eventName}";
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->useLogName('payment')
    //         ->logAll()
    //         ->logOnlyDirty();
    // }


    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
