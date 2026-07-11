<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
class Membership extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'memberships';

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
        return "Membership has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('membership')
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
