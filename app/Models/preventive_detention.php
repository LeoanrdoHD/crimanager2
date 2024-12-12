<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preventive_detention extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'conviction_id',
        'prison_id',
        'prison_entry_date',
        'prison_release_date',
    ];
    public function prison()
    {
        return $this->belongsTo(Prison::class, 'prison_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function criminalConviction()
    {
        return $this->belongsTo(conviction::class, 'conviction_id');
    }
    public function detentionType()
    {
        return $this->belongsTo(detention_type::class, 'detention_type_id');
    }
}
