<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faction extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_id',
        'name',
        'allegiance',
        'government',
        'influence',
        'state',
        'happiness',
        'active_states',
        'pending_states',
        'recovering_states',
        'updated_at',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    public function history(): HasMany
    {
        return $this->hasMany(FactionHistory::class, 'faction_id', 'id');
    }

}
