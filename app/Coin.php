<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description', 
        'image', 
        'conversion_id',
    ];

    /**
     * Dependency
     *
     * @var array
     */
    protected $with = [
        'conversion',
    ];

    /**
     * Relationship
     *
     * @return BelongsTo
     */
    public function conversion()
    {
        return $this->belongsTo(Conversion::class, 'conversion_id');
    }
    
    /**
     * Relationship
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class, 
            'coins_x_users', 
            'coin_id', 
            'user_id' 
        )->withPivot('balance');
    }
}
