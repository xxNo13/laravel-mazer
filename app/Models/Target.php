<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'target',
        'output_id',
        'suboutput_id',
        'user_id',
        'type',
        'user_type',
        'duration_id'
    ];

    public function rating(){
        return $this->hasOne(Rating::class);
    }

    public function standard(){
        return $this->hasOne(Standard::class);
    }

    public function output(){
        return $this->belongsTo(Output::class);
    }
    public function suboutput(){
        return $this->belongsTo(Suboutput::class);
    }
}
