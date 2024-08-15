<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskNote;
use App\Models\TaskFlowTemplate;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;



class TaskController extends Controller
{
    protected $fileService;


    public function __construct(
        FileService $fileService
    )
    {
        $this->fileService = $fileService;
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
        return view('tasks.show', compact('task'));
    }


    //get edit page
    public function edit($id)
    {    
        $task=Task::with('task_flow_template')->find($id);
        $this->authorize('update', $task);

        $task_flow_template=TaskFlowTemplate::get();
        $assign_user = '';
        $task_flow_template_user = TaskFlowTemplate::with('first_order')->find($task->task_flow_template->id);
        if ($task_flow_template_user) {
            $assign_user = $task_flow_template_user->getAssignedUsers()['response'];
        } 

        return view('tasks.edit', compact('task','task_flow_template','assign_user'));
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

        $task->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'estimated_hours' => $request->estimated_hours,
            'task_flow_template_id'=>$request->task_flow_template_id,
            'assigned_to' => $request->assigned_to,
        ]);

        $file = $request->file('file');


        $check_file=$this->check_file($file,$task,$request->hasFile('file'));

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
        $this->authorize('update', $task);
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

}
