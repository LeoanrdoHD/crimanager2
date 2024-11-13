<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    protected $fillable = [
        'organization_name',
        'Criminal_Organization_Specialty',
    ];
    public $timestamps = false;
    public function criminals()
    {
        return $this->belongsToMany(Criminal::class, 'criminal_organizations', 'organization_id', 'criminal_id');
    }
}
