<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class System extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'x',
        'y',
        'z',
        'distance',
        'faction_id',
        'economy',
        'second_economy',
        'allegiance',
        'government',
        'security',
        'population',
        'powers',
        'pps',
        'updated_at',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    
    // SCOPED
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopePopulation($query, $population)
    {

        //return $query->where('population', $name);
    }

    // RELATIONSHIPS
    public function faction() : HasOne
    {
        return $this->hasOne(Faction::class, 'id', 'faction_id');
    }

    public function factions() : HasMany
    {
        return $this->hasMany(Faction::class, 'system_id', 'id')->orderBy('id', 'desc');
    }

    public function stations() : HasMany
    {
        return $this->hasMany(Station::class, 'system_id', 'id');
    }

    public function conflicts() : HasMany
    {
        return $this->hasMany(Conflict::class, 'system_id', 'id')->orderBy('id', 'desc');
    }

    public function stars(): HasMany
    {
        return $this->hasMany(Star::class, 'system_id', 'id');
    }

    public function planets(): HasMany
    {
        return $this->hasMany(Planet::class, 'system_id', 'id');
    }

    public function thargoid(): HasOne {
        return $this->hasOne(ThargoidWar::class, 'system_id', 'id');
    }
}
