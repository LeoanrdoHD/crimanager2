<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_aliase extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'alias_name',
        'alias_identity_number',
        'nationality_id',
    ];

    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

}
