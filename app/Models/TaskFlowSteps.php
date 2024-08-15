<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;


class TaskFlowSteps extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'task_flow_template_id',
        'order',
        'to_role',
        'sendEmailNotification',
        'descript'
    ];
    
    public function task_flow_template_id()
    {
        return $this->belongsTo(TaskFlowTemplate::class);
    }

        
    public function role()
    {
        return $this->belongsTo(UserRole::class,'to_role');
    }

    static function save_date($template_id,$data){
        Log::info(['data'=>$data]);
        Log::info(['data_step'=>$data['step']]);

        foreach($data['step'] as $key=>$stepData){
            $step = new self;
            $step->task_flow_template_id=$template_id;
            $step->to_role=$stepData['to_role'];
            $step->order=$key;
            $step->sendEmailNotification=$stepData['sendEmailNotification'];
            $step->descript=$stepData['descript'];
            $step->save();
        }

        return $step;
    }

    static function destroy_steps($template_id){
        $steps = TaskFlowSteps::where('task_flow_template_id', $template_id)->get();
        if($steps->count() > 0){
            $response=TaskFlowSteps::where('task_flow_template_id', $template_id)->delete();
        }
        return $response;
    }

    public function getRoleNameAttribute()
    {
        return $this->role ? $this->role->role_name : null;
    }

}
