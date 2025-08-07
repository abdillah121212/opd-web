<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function users()
    {
        return $this->hasMany(User::class);
    }
    

    public function hasVerifiedName()
{
    return !is_null($this->name_verified_at);
}

public function markNameAsVerified()
{
    return $this->forceFill([
        'name_verified_at' => $this->freshTimestamp(),
    ])->save();
}

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'level_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name_verified_at' => 'datetime',
            'level_id' => 'integer',
            'password' => 'hashed',
        ];
    }
}
