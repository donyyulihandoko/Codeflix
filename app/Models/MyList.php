<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class MyList extends Model
{
    /** @use HasFactory<\Database\Factories\MyListFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'my_lists';
    protected $fillable = ['user_id', 'movie_id'];

    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "My List has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('my_list')
            ->logAll()
            ->logOnlyDirty();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function rating(): HasManyThrough
    {
        return $this->hasManyThrough(Rating::class, Movie::class);
    }
}
