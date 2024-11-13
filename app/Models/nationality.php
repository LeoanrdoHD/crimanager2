<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nationality extends Model
{
    protected $fillable = [
        'nationality_name',
    ];
    public $timestamps = false;
}
