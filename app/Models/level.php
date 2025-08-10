<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    // optional: protected $table = 'levels';

    protected $fillable = ['name'];

    /**
     * Semua level memiliki banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'level_id');
    }
}
