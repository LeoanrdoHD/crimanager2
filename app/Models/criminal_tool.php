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
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function toolType()
    {
        return $this->belongsTo(tools_type::class, 'tool_type_id');
    }
}
