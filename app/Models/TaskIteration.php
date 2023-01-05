<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskIteration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'task_id',
        'trigger_date',
        'status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
