<?php

namespace App\Models;

use App\Enums\FreelancerStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Freelancer extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'price_per_hour',
        'image',
        'phone_number',
        'status',
        'portfolio_links'
        ];

    protected $appends = ['full_name', 'review'];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'status' => FreelancerStatus::class,
        'portfolio_links' => 'array',
        'skills_summary' => 'array',
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

    protected function fullName() : Attribute {
        return Attribute::make (
            get: function () {
                if ($this->relationLoaded('user') && $this->user) {
                    return ucwords($this->user->name);
                }
                return 'Freelancer';
            }
        );
    }

    protected function image() : Attribute {
        return Attribute::make(
            get: function ($value) {
            if (!empty($value)) {
                return asset('storage/' . $value);
            }
            return asset('images/photo_2026-04-16_02-01-45.jpg');
        }
        );
    }

    protected function review() : Attribute {
        return Attribute::make(
            get: function() {
                $avg = $this->reviews_avg_rating;
                if ($avg === null) {
                    return "No reviews yet";
                }
                return number_format($avg, 1) . " ⭐";
            }
        );
    }

    protected function joinedAt() : Attribute {
        return Attribute::make(
            get: fn() => $this->created_at?$this->created_at->diffForHumans():null,
        );
    }
    protected function phoneNumber(): Attribute
        {
        return Attribute::make(
            set: function ($value) {
                $value = preg_replace('/\D/', '', $value);
                if (strlen($value) === 10 && str_starts_with($value, '0')) {
                    return '+963' . substr($value, 1);
                }
                if (strlen($value) === 9 && str_starts_with($value, '9')) {
                    return '+963' . $value;
                }
                return $value;
            }
        );
    }

    protected static function booted(){
        static::addGlobalScope('active_and_verified', function(Builder $builder){
            $builder->whereHas('user', function($query){
                $query->where('is_verified', true);
            })->where('status' , FreelancerStatus::AVAILABLE);
        });
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('status', FreelancerStatus::AVAILABLE);
    }

    public function scopeOrderByRating($query) {
        return $query->withAvg('reviews','rating')->orderByDesc('reviews_avg_rating');
    }
}
