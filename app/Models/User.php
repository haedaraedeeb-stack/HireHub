<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

#[Fillable(['name', 'email', 'password', 'role', 'is_verified', 'verification_code', 'city_id' ])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, City::class);
    }

    public function freelancer()
    {
        return $this->hasOne(Freelancer::class);
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'freelancer_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'freelancer_id');
    }

    protected function password() : Attribute {
        return Attribute::make (
            set: fn($value) => Hash::make($value),
        );
    }
}
