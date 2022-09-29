<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'superior1_id',
        'superior1_status',
        'superior2_id',
        'superior2_status',
        'type'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
