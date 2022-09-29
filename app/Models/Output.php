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
        'user_id',
        'type'
    ];

    public function suboutputs(){
        return $this->hasMany(Suboutput::class);
    }

    public function targets(){
        return $this->hasMany(Target::class);
    }
}
