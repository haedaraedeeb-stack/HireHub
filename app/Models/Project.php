<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'budget_type',
        'budget',
        'deadline',
        'status',
        'accepted_offer_id'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag')->withTimestamps();
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function acceptedOffer()
    {
        return $this->belongsTo(Offer::class, 'accepted_offer_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    protected function budget() : Attribute {
        return Attribute::make(
            get: function (mixed $value) {
                $formattedBudget = number_format($value);
                return $this->budget_type === 'hourly'
                ? '$' . $formattedBudget . '/hr'
                : $formattedBudget . ' USD';
            }
        );
    }

    protected function deadline() : Attribute {
        return Attribute::make(
            get: function(mixed $value) {
            if (!$value) {
                return "No deadline set";
                }
            $numberOfDays = now()->diffInDays($value, false);
            if($numberOfDays > 0) {
                return "$numberOfDays days left";
            } elseif ($numberOfDays < 0) {
                return "Expired";
            }
            else{
                return "Deadline is today";
            }
        });
    }

    protected static function booted() {
        static::addGlobalScope('opened', function(Builder $builder){
            $builder->where('status', 'open');
        });
    }

    public function scopeoverBudget($query, $budget){
        return $query->where('budget', '>', $budget);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at',[
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }
}
