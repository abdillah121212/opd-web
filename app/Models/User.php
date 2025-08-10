<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // optional: protected $table = 'users';

    protected $fillable = [
        'name',
        'level_id',
        'password',
        'status',
        'delete_add',
        'name_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'name_verified_at' => 'datetime',
        'level_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel levels
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    /**
     * Helper untuk verifikasi 'name' (sesuai yang kamu punya).
     */
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
}
