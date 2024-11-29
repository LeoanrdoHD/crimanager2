<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preventive_detention extends Model
{
    protected $fillable = [
        'criminal_id',
        'conviction_id',
        'prison_id',
        'prison_entry_date',
        'prison_release_date',
    ];
    public function prision()
    {
        return $this->belongsTo('app\Models\prison');
    }
}
