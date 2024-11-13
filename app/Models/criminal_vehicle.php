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
    public function vehicle_color()
    {
        return $this->belongsTo('app\Models\vehicle_color');
    }
    public function vehicle_type()
    {
        return $this->belongsTo('app\Models\vehicle_type');
    }
    public function brand_vehicle()
    {
        return $this->belongsTo('app\Models\brand_vehicle');
    }
    public function industrie()
    {
        return $this->belongsTo('app\Models\industrie');
    }
    public function vehicle_service()
    {
        return $this->belongsTo('app\Models\vehicle_service');
    }
    public function relationship_with_owner()
    {
        return $this->belongsTo('app\Models\relationship_with_owner');
    }
}
