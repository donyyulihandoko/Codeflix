<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'active',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    //  Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Subscription has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('subscription')
            ->logAll()
            ->logOnlyDirty();
    }

    // Relationships
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan() :BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
