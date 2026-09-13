<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'plans';

    protected $fillable = [
        'title',
        'slug',
        'price',
        'duration',
        'resolution',
        'max_devices',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Plan has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('plan')
            ->logAll()
            ->logOnlyDirty();
    }

    // Relationships
    public function subscriptions() :HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments() :HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
