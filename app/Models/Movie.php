<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory, LogsActivity;

    protected $table = 'movies';
    protected $fillable = [
        'title',
        'slug',
        'description',
        // 'director',
        // 'writers',
        // 'stars',
        'poster',
        'release_date',
        'duration',
        'url_720',
        'url_1080',
        'url_4k'
    ];

    protected $casts = [
        'release_date' => 'datetime'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Activity Log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Movie has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('movie')
            ->logAll()
            ->logOnlyDirty();
    }

    // Relationship
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_movie', 'movie_id', 'category_id');
    }

    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class, 'writer_movie', 'movie_id', 'crew_id');
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class, 'director_movie', 'movie_id', 'crew_id');
    }

    public function stars(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class, 'star_movie', 'movie_id', 'crew_id');
    }
}
