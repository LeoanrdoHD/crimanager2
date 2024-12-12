<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_vehicle extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'vehicle_color_id',
        'type_id',
        'year',
        'brand_id',
        'model',
        'industry_id',
        'license_plate',
        'vehicle_service_id',
        'details',
        'itv_valid',
        'user_name',
        'user_ci',
        'relationship_with_owner_id',
        'observations',
        'driver_name',
    ];
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }

    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }

    public function vehicleColor()
    {
        return $this->belongsTo(vehicle_color::class, 'vehicle_color_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(vehicle_type::class, 'type_id');
    }

    public function brandVehicle()
    {
        return $this->belongsTo(brand_vehicle::class, 'brand_id');
    }

    public function industry()
    {
        return $this->belongsTo(industrie::class, 'industry_id');
    }

    public function vehicleService()
    {
        return $this->belongsTo(vehicle_service::class, 'vehicle_service_id');
    }

    public function relationshipWithOwner()
    {
        return $this->belongsTo(relationship_with_owner::class, 'relationship_with_owner_id');
    }
}
