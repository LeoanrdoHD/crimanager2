<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_tool extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'tool_type_id',
        'tool_details',
    ];
}
