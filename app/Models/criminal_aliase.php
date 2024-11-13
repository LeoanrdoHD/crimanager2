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
}
