<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conviction extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'detention_type_id',
    ];
    public function extradition()
    {
        return $this->hasMany('app\Models\extradition'::class, 'conviction_id');
    }
    public function house_arrest()
    {
        return $this->hasMany('app\Models\house_arrest'::class, 'conviction_id');
    }
    public function preventive_detention()
    {
        return $this->hasMany('app\Models\preventive_detention'::class, 'conviction_id');
    }
    public function liberty()
    {
        return $this->hasMany('app\Models\liberty'::class, 'conviction_id');
    }
}
