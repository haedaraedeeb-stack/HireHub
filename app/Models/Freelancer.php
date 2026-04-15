<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'price_per_hour',
        'image',
        'phone_number',
        'status',
        'profile_link'
        ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'freelancer_skill')
        ->withPivot('experience_years')->withTimestamps();
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'freelancer_id', 'user_id');
    }
}
