<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_specialty extends Model
{
    protected $fillable = [
        'specialty_name',
    ];
    public $timestamps = false;
}
