<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'endpoint',
        'method',
        'duration',
        'status_code',
        'user_id',
        'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
