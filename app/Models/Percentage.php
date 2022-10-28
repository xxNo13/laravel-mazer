<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'core',
        'strategic',
        'support',
        'type',
        'userType',
        'user_id',
        'duration_id'
    ];

    public function supports(){
        return $this->hasMany(SuppPercentage::class);
    }
}
