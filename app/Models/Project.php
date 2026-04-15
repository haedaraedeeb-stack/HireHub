<?php

namespace App\Models;

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
}
