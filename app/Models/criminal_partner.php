<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_partner extends Model
{
    protected $fillable = [
    'criminal_id',
    'partner_name',
    'partner_ci',
    'relationship_type_id',
    'partner_address',
    ];

    public function relationship_type()
    {
        return $this->belongsTo('app\Models\relationship_type');
    }
}
