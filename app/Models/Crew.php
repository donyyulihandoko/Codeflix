<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Crew extends Model
{
    /** @use HasFactory<\Database\Factories\CrewFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'crews';
    protected $fillable = [
        'name',
        'slug',
        'photo',
        'biography',
        'birth_date',
        'place_of_birth',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Crew has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('crew')
            ->logAll()
            ->logOnlyDirty();
    }
    // Relationships
    public function directedMovies() : BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'director_movie', 'crew_id', 'movie_id');
    }

    public function writtenMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'writer_movie', 'crew_id', 'movie_id');
    }

    public function starredMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'star_movie', 'crew_id', 'movie_id');
    }
}
