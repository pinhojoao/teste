<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'btc', 
        'usd', 
    ];

    /**
     * Relationship
     *
     * @return HasMany
     */
    public function coins()
    {
        return $this->hasMany(Coin::class);
    }
}
