<?php

namespace App\Http\Controllers;

// model
use App\Models\Task;
use App\Models\TaskFlowSteps;
use App\Models\TaskNote;
use App\Models\TaskFlowTemplate;
use App\Models\User;

// service
use App\Services\FileService;
use App\Services\MailService;

//other
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $fileService;
    protected $mailService;


    public function __construct(
        FileService $fileService,
        MailService $mailService
    )
    {
        $this->fileService = $fileService;
        $this->mailService = $mailService;

    }

    public function index()
    {
        $tasks = Task::with('creator', 'assignee')->where('valid','!=',Task::STATUS_INVALID)->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {

        $task_flow_template=TaskFlowTemplate::get();
        return view('tasks.create',compact('task_flow_template'));
    }

    public function store(Request $request)
    {        
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_hours' => 'required|numeric',
            'task_flow_template_id'=> 'required'
        ]);

        $task=Task::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'estimated_hours' => $request->estimated_hours,
            'task_flow_template_id'=> $request->task_flow_template_id,
            'created_by' => Auth::id(),
        ]);


        if($request->hasFile('file')){
            $fileService = new FileService($request, 'file');
            $file_path = $fileService->saveFileToTaskFile($request->file('file'), 'taskfile/'.$task->id,$task->id);
            $task->files()->saveMany($file_path);
            if (is_array($file_path) && isset($file_path['error'])) {
                return back()->withErrors($file_path['error']);
            }
        }

        return redirect()->route('tasks.index')->with('success', '工作單已創建');
    }

    public function show(Task $task)
    {
        //權限
        $this->authorize('view', $task);

        $task_id=$task->id;
        $task_note=TaskNote::where('task_id',$task_id)->with('task_flow_step.role_to_user')->get();
        $auth=Auth::id();

        // $TaskNote=new TaskNote;
        $get_task_current_step =TaskNote::get_task_current_step($task_id);
        $get_task_next_step =TaskNote::get_task_next_step($task_id);


        return view('tasks.show', compact('task',"task_note",'auth','get_task_current_step','get_task_next_step'));
    }


    //get edit page
    public function edit($id)
    {    
        $task=Task::with('task_flow_template')->find($id);
        $this->authorize('update', $task);
        $task_flow_template=TaskFlowTemplate::get();
        $assign_user = '';
        $check_task_step_status=0;

        $task_flow_template_user = TaskFlowTemplate::with('first_order')->find($task->task_flow_template->id);

        if ($task_flow_template_user) {
            $assign_user = $task_flow_template_user->getAssignedUsers()['response'];
            $check_task_step_status=TaskNote::where('task_id',$id)->where('step',1)->select('status')->first();
        } 
        return view('tasks.edit', compact('task','task_flow_template','assign_user','check_task_step_status'));
    }

    //post task update 
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_hours' => 'required|numeric',
            'task_flow_template_id' => 'required|integer',
            'file' => 'file|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/tiff,image/webp,image/svg+xml,application/pdf,application/x-www-form-urlencoded,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,multipart/form-data,text/plain|max:2048',
        ]);


        $this->executeInTransaction(function()use($request,$task){
            // 更新任务
            if (!$task->update([
                'subject' => $request->subject,
                'description' => $request->description,
                'estimated_hours' => $request->estimated_hours,
                'task_flow_template_id' => $request->task_flow_template_id,
                'assigned_to' => $request->assigned_to,
            ])) {
                Log::debug('Task update failed');
                throw new \Exception('Task update failed');
            }
            Log::info('Task update success');

            $get_task_steps=TaskFlowSteps::where('task_flow_template_id',$request->task_flow_template_id)->get();

            // dd(['get_task_steps'=>$get_task_steps[0]['sendEmailNotification']]);

            if($get_task_steps->isNotEmpty()){
                $task_note=new TaskNote;
                $result = $task_note->create_for_task_flow_step($get_task_steps,$request->assigned_to,$task->id);

                //取第一步驟且需要寄送郵件sendEmailNotification ==1 
                if($get_task_steps[0]['order']==1 && $get_task_steps[0]['sendEmailNotification']==1){
                    $data=$request->all();
                    $this->mailService->sendNotificationMail('sendEmailNotification_first',$data,$data['assigned_to']);
                }

                if( $result == "success" && $request->hasFile('file')){
                    $file = $request->file('file');
                    $this->check_file($file,$task,true);
                }

            }
        });
        return redirect()->route('tasks.index')->with('success', '工作單已更新');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', '工作單已刪除');
    }

    public function task_cancel(Request $request, Task $task)
    {
        $this->authorize('update', $task->find($request->id));

        try{
            $task->where('id',$request->id)->update([
                'valid'=>Task::STATUS_INVALID,
                'updated_by'=>Auth::id()
            ]);
        }catch(\Exception $e){
            Log::debug(['task_cancel'=>$e]);
            return response()->json(['message' => $e], 500);
        }
        return response()->json(['message' => 'task cancel successfully'], 200);
    }

    public function create_task_note(Request $request, Task $task){
        $request->validate([
            'note'=>'require',
            'actual_hours'=>'required|numeric'
        ]);

        TaskNote::create([
            'task_id'=>$task->id,
            'note'=>$request->note,
            'actual_hours'=>$request->actual_hours,
            'created_by'=>Auth::id(),
        ]);

        $this->check_file($request,$task,$request->hasFile('file'));

        return redirect()->route('tasks.index')->with('success', '任務處理已更新');
    }

    public function check_file($file,$task,$hasfile=false){
        if ($hasfile) {
            $file_path = $this->fileService->saveFileToTaskFile($file, 'taskfile/' . $task->id, $task->id);
    
            if (is_array($file_path) && isset($file_path['error'])) {
                return back()->withErrors($file_path['error']);
            }
    
            $task->files()->saveMany($file_path);
        }
    
        return null;
    }

    public function get_task_assign(Request $request)
    {
        $task_flow_template = TaskFlowTemplate::with('first_order')->find($request->task_flow_template_id);
        if ($task_flow_template) {
            $result = $task_flow_template->getAssignedUsers();
            return response()->json([$result['type'] => $result['response']]);
        } else {
            return response()->json(['error' => 'Task flow template not found.'], 404);
        }
    }

    public function update_task_note(Request $request){
        //fix 要增加檔案上傳等功能，預計將檔案功能部份寫在taskfile model 分別管理
        $request->validate([
            'note' => 'required|string',
            'actual_hours' => 'required|numeric',
            'status' => 'required',
            "assign_next" => "required",
            'file' => 'file|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/tiff,image/webp,image/svg+xml,application/pdf,application/x-www-form-urlencoded,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,multipart/form-data,text/plain|max:2048',
        ]);

        $data=$request->all();

        $this->executeInTransaction(function()use($data){
            Task::where('id',$data['task_id'])->update([
                "assigned_to"=>$data['assign_next'],
                "updated_by"=>Auth::id(),
            ]);
    
            TaskNote::where("id",$data['note_id'])->where('step',$data['step'])
            ->update([
                "note"=>$data['note'],
                "actual_hours"=>$data['actual_hours'],
                "status"=>$data['status'],
                "updated_by"=>Auth::id()
            ]);
            //step有完成才做下步驟更新，最後一不不會有assign_next
            if($data['status']==1 && isset($data['assign_next'])){
                //取得下一步驟的step
                $task_next_step= TaskNote::get_task_next_step($data['task_id']);
                    TaskNote::where('id',$task_next_step->id)->update([
                        "assign_to"=>$data['assign_next'],
                        "updated_by"=>Auth::id()
                    ]);
                    $check_task_step_email=TaskFlowSteps::where('id',$task_next_step->task_flow_step_id);
                    if($check_task_step_email['sendEmailNotification']==1){
                        $this->mailService->sendNotificationMail('sendEmailNotification',$data,$data['assign_next']);
                    }
            }
        });

        return redirect()->route('tasks.index')->with('success','Handle tsak success');
        
    }

    public function update_task_note_final(Request $request){
        $request->validate([
            'note' => 'required|string',
            'actual_hours' => 'required|numeric',
            'status' => 'required',
            'file' => 'file|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/tiff,image/webp,image/svg+xml,application/pdf,application/x-www-form-urlencoded,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,multipart/form-data,text/plain|max:2048',
        ]);

        $data=$request->all();

        $this->executeInTransaction(function()use($data){
            Task::where('id',$data['task_id'])->update([
                "updated_by"=>Auth::id(),
            ]);
    
            TaskNote::where("id",$data['note_id'])->where('step',$data['step'])
            ->update([
                "note"=>$data['note'],
                "actual_hours"=>$data['actual_hours'],
                "status"=>$data['status'],
                "updated_by"=>Auth::id()
            ]);

            $task_temp_count=Task::where('id',$data['task_id'])->with('task_flow_step')->count();
            $get_task_current_step=TaskNote::get_task_current_step($data['task_id']);
            if($task_temp_count==$get_task_current_step['step']){
                Task::where('id',$data['task_id'])->update([
                    "valid"=>2,
                    "updated_by"=>Auth::id(),
                ]);
            }
        });
        return redirect()->route('tasks.index')->with('success','Handle tsak success');

    }

    public function getTasksTable(Request $request){

        if($request->json()){
            $tasks = Task::with('creator', 'assignee')->where('valid','!=',Task::STATUS_INVALID);
            
            return Datatables::eloquent($tasks)
            ->addColumn('subject',function($tasks){
                return $tasks->subject;
            })
            ->addColumn('descript',function($tasks){
                return $tasks->description;
            })
            ->addColumn('estimated_hours',function($tasks){
                return $tasks->estimated_hours;
            })
            ->addColumn('name',function($tasks){
                return $tasks->creator->name;
            })
            ->addColumn('assign_to',function($tasks){
                $editUrl = route('tasks.edit', $tasks->id);
                return ($tasks->assignee->name)??"<a href='$editUrl'>未指派</a>";
            })
            ->addColumn('active',function($tasks){
                //url
                $handlelUrl = route('tasks.show', $tasks->id);
                $editUrl = route('tasks.edit', $tasks->id);
                $cancelUrl = route('task_cancel');
                //btn
                $handleButton="<a href='$handlelUrl' class='btn btn-sm btn-info'>前往處理</a>";
                $editButton = "<a href='$editUrl' class='btn btn-sm btn-warning'>編輯</a>";
                $cancelButton = 
                    "<a onclick=\"confirmCancel(event, '$cancelUrl', $tasks->id)\" class='btn btn-sm btn-danger'>取消任務</a>" 
                    ;
                return $handleButton. ' ' .$editButton . ' ' . $cancelButton;
            })
            ->rawColumns(['active','assign_to'])
            ->make(true);

        }

    }


}
