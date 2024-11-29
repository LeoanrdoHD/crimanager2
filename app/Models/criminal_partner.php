<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_partner extends Model
{
    protected $fillable = [
        'criminal_id',
        'partner_name',
        'relationship_type_id',
        'partner_address',
    ];

    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function relationshipType()
    {
        return $this->belongsTo(Relationship_Type::class, 'relationship_type_id');
    }
}
