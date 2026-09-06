<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
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
        'payment_status',
        'midtrans_snap_token',
        'midtrans_booking_code',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Status Constants
    public const STATUS_PENDING    = 'pending';
    public const STATUS_SETTLEMENT = 'settlement';
    public const STATUS_CAPTURE    = 'capture';
    public const STATUS_SUCCESS    = 'success';
    public const STATUS_EXPIRE     = 'expire';
    public const STATUS_CANCEL     = 'cancel';
    public const STATUS_DENY       = 'deny';

    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Payment has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('payment')
            ->logAll()
            ->logOnlyDirty();
    }

    // Helper Methods
    public function isSuccess(): bool
    {
        return in_array($this->payment_status, [self::STATUS_SETTLEMENT, self::STATUS_CAPTURE, self::STATUS_SUCCESS], true);
    }

    public function isPending(): bool
    {
        return $this->payment_status === self::STATUS_PENDING;
    }

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
