<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = [
        'title',
        'price',
        'duration',
        'resolution',
        'max_devices',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function memberships() :HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
