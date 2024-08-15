<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Task extends BaseModel
{
    use HasFactory,Notifiable;

    public const STATUS_INVALID = 0;
    public const STATUS_VALID = 1;
    public const STATUS_HANDLE = 2;
    public const STATUS_PROBLEM = 3;
    public const STATUS_ERROR = 4;
    public const STATUS_DONE = 5;

    protected $fillable = [
        'subject',
        'description',
        'estimated_hours',
        'created_by',
        'assigned_to',
        'updated_by',
        'task_flow_template_id',
        'valid'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function task_flow_template(){
        return $this->belongsTo(TaskFlowTemplate::class, 'task_flow_template_id');

    }

    public function notes()
    {
        return $this->hasMany(TaskNote::class);
    }

    public function files()
    {
        return $this->hasMany(TaskFile::class);
    }

}
