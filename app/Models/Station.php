<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'system_id',
        'market_id',
        'name',
        'type',
        'distance_to_arrival',
        'allegiance',
        'government',
        'economy',
        'state',
        'landing_pads',
        'faction_id',
        'updated_at'
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    public function economies() : HasMany
    {
        return $this->hasMany(Economy::class, 'station_id', 'id');
    }

    public function services() : HasMany
    {
        return $this->hasMany(Service::class, 'station_id', 'id');
    }

    public function market() : HasOne
    {
        return $this->hasOne(Market::class, 'station_id', 'id');
    }

    public function system() : BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id');
    }
}
