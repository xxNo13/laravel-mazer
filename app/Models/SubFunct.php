<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubFunct extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_funct',
        'funct_id',
        'user_id',
        'type',
        'user_type',
        'duration_id',
        'isDesignated'
    ];

    public function outputs(){
        return $this->hasMany(Output::class);
    }

    public function funct(){
        return $this->belongsTo(Funct::class);
    }
}
