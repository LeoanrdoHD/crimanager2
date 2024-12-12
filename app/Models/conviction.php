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

    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }

    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function detentionType()
    {
        return $this->belongsTo(detention_type::class, 'detention_type_id');
    }
    public function extraditions()
    {
        return $this->hasMany(Extradition::class, 'conviction_id');
    }

    public function houseArrests()
    {
        return $this->hasMany(house_arrest::class, 'conviction_id');
    }

    public function preventiveDetentions()
    {
        return $this->hasMany(preventive_detention::class, 'conviction_id', 'detention_type_id');
    }

    public function liberties()
    {
        return $this->hasMany(Liberty::class, 'conviction_id');
    }
}
