<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class TaskNote extends BaseModel
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'task_id',
        'note',
        'actual_hours',
        'assign_to',
        'step',
        'status',
        'task_flow_step_id',
        'created_by',
        'updated_by',

    ];
    
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function task_flow_step()
    {
        return $this->belongsTo(TaskFlowSteps::class,'task_flow_step_id');
    }

    public function assign_to()
    {
        return $this->belongsTo(User::class,'assign_to');
    }

    public function creator()
    {
        
        return $this->belongsTo(User::class,'created_by');
    }

    public function create_for_task_flow_step($task_folw_steps,$assigned_to,$task_id){
        // dd($assigned_to);
        foreach($task_folw_steps as $key=>$step){
            $task_note=new self;

            $task_note->task_id = $task_id;

            //只有第一步驟需要寫入assigned_to
            if($step['order']==1){
                $task_note->assign_to = $assigned_to;
            }

            $task_note->step = $step['order'];
            $task_note->status = 0;
            $task_note->task_flow_step_id = $step['id'];
            $task_note->created_by = Auth::id();
            $task_note->updated_by = Auth::id();

            $task_note->save();
        }
        Log::debug(['create_for_task_flow_step'=>$task_note]);

        return 'success';
    }

    static function get_task_current_step($task_id){
        //找task_notes table 已完成 最後一筆，沒有任何一筆完成回傳第一步驟
        $response=TaskNote::where('status',1)->where('task_id',$task_id)->orderby('step','desc')->first();
        if(empty($response)){
            $response=TaskNote::where('task_id',$task_id)->orderby('step','asc')->first();
        }
        return $response;
    }

    static function get_task_next_step($task_id){
        //找task_notes table 尚未完成的優先筆，沒有任表尚未完成則回傳已完成的最後一筆
        $response=TaskNote::where('status',0)->where('task_id',$task_id)->orderby('step','asc')->first();
        if(empty($response)){
            $response=TaskNote::where('status',1)->where('task_id',$task_id)->orderby('step','desc')->first();
        }
        return $response;

    }

}
