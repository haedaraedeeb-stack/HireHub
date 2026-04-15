<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, City::class);
    }
}
