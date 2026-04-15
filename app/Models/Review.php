<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'project_id',
        'comment',
        'rating',
        'type',
        'client_id',
        'freelancer_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}
