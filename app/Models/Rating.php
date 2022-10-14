<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'alloted_budget',
        'responsible',
        'accomplishment',
        'efficiency',
        'quality',
        'timeliness',
        'average',
        'remarks',
        'target_id',
        'user_id',
        'type',
        'duration_id'
    ];
}
