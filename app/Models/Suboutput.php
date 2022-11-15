<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suboutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'suboutput',
        'output_id',
        'user_id',
        'type',
        'user_type',
        'duration_id',
        'isDesignated'
    ];

    public function targets(){
        return $this->hasMany(Target::class);
    }
    public function output(){
        return $this->belongsTo(Output::class);
    }
}
