<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'freelancer_id',
        'project_id',
        'price',
        'letter',
        'status',
        'delivery_days'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

        public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
