<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration',
        'resolution',
        'max_devices',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
