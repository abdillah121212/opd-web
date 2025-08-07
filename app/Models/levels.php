<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class levels extends Model
{

    protected $fillable = ['name'];
    
    public function levels()
    {
        return $this->belongsTo(levels::class, 'class');
    }
}
