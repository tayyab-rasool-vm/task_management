<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'occurrence_id',
        'name',
        'start_date',
        'end_date',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class);
    }

    public function taskIterations()
    {
        return $this->hasMany(TaskIteration::class);
    }
}
