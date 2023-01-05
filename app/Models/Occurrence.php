<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    protected $fillable = [
        'name',
        'function_name'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
