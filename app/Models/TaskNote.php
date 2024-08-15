<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class TaskNote extends BaseModel
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'task_id',
        'note',
        'actual_hours',
    ];
    
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
