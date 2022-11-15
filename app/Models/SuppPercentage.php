<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppPercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'percent',
        'percentage_id',
        'user_id',
        'duration_id',
        'sub_funct_id',
        'funct_id'
    ];
}
