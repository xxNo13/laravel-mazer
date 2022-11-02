<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'output',
        'funct_id',
        'sub_funct_id',
        'user_id',
        'type',
        'user_type',
        'duration_id'
    ];

    public function funct(){
        return $this->belongsTo(Funct::class);
    }

    public function subFunct(){
        return $this->belongsTo(SubFunct::class);
    }

    public function suboutputs(){
        return $this->hasMany(Suboutput::class);
    }

    public function targets(){
        return $this->hasMany(Target::class);
    }
}
