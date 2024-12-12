<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_complice extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'complice_name',
        'CI_complice',
        'detail_complice',
    ];
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
}
