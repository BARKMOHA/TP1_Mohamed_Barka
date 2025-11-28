<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function critics()
{
    return $this->hasMany(Critic::class);
}
}
