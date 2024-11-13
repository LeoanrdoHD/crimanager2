<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_fingerprint extends Model
{
    protected $fillable = [
        'criminal_id',
        'left_thumb',
        'left_index',
        'left_middle',
        'left_ring',
        'left_little',
        'right_thumb',
        'right_index',
        'right_middle',
        'right_ring',
        'right_little',
    ];
}
