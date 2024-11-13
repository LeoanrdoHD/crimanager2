<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_organization extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'organization_id',
        'criminal_rol',
    ];
    public function organization()
    {
        return $this->belongsTo('app\Models\organization');
    }
}
