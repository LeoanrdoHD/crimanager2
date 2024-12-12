<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class extradition extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'conviction_id',
        'country_id',
        'state_id',
        'extradition_date',
    ];
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function criminalConviction()
    {
        return $this->belongsTo(conviction::class, 'conviction_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
