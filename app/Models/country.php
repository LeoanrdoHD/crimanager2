<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $fillable = [
        'country_name',
    ];
    public $timestamps = false;
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
