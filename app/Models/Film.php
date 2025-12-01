<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_film', 'film_id', 'actor_id');
    }
    
    public function critics()
    {
        return $this->hasMany(Critic::class);
    }
}
