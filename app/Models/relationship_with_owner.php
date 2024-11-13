<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relationship_with_owner extends Model
{
    protected $fillable = [
        'relationship_name',
    ];
    public $timestamps = false;
}
