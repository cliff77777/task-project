<?php

namespace App\Http\Controllers;

//model
use App\Models\TaskFlowTemplate;
use App\Models\UserRole;
use App\Models\TaskFlowSteps;

//other
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Yajra\DataTables\Facades\DataTables;




class TaskFlowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $task_flow_template=TaskFlowTemplate::withCount('steps')->paginate(10);
        return view('task_flow.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user_role=UserRole::get();
        
        return view('task_flow.create',compact('user_role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->all();

        $request->validate([
            'flow_name' => 'required|string|max:255',
            'step' => 'required|array|min:1', 
            'step.*.sendEmailNotification' => 'required|in:1,0', 
            'step.*.to_role' => 'required|integer|exists:user_roles,id', 
            'step.*.descript' => 'required|string|max:255', 
        ]);

        try {
            $this->executeInTransaction(function () use ($data) {
                Log::info(['task_flow_store data'=>$data]);
            //去TaskFlowTemplate model 做
            $task_flow_template=TaskFlowTemplate::save_date($data);
            //去TaskFlowStep model 做
            TaskFlowSteps::save_date($task_flow_template->id,$data);
            });
        }catch(\Exception $e){
            Log::error('An error occurred while create task flow: ' . $e->getMessage());
                return redirect()->back()->with('error','An error occurred while create task flow. Error:'.$e);
        }
        return redirect()->route('task_flow.index')->with('success','Create task flow successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $template=TaskFlowTemplate::with('steps.role')->find($id);
        return view('task_flow.show',compact('template'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $template=TaskFlowTemplate::with('steps.role')->find($id);
        $user_role=UserRole::get();
        
        return view('task_flow.edit',compact('template','user_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskFlowTemplate $taskFlowTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $target_id=$request->id;
            Log::info(['task_flow_destory id'=>$target_id]);
            //去TaskFlowTemplate model 做delete 設置了cascade 同步刪除flow_steps
            TaskFlowTemplate::destroy_template($target_id);
        }catch(\Exception $e){
            Log::error('An error occurred while delete task flow: ' . $e->getMessage());
                return response()->json(['message' => 'An error occurred while delete task flow please try again later'], 500);
        }
        return response()->json(['message' => 'Delete task flow successfully'], 200);
    }

    public function getTaskFlowTable(Request $request){
        if ($request->ajax()) {
            $query = TaskFlowTemplate::with('creator')
            ->select('task_flow_templates.*')
            ->withCount('steps');

            // 使用 DataTables 處理數據
            return DataTables::eloquent($query)
            ->addColumn('task_flow_name', function ($query) {
                return $query->task_flow_name;
            })
            ->addColumn('name', function ($query) {
                return $query->creator->name;
            })
            ->addColumn('steps_count', function ($query) {
                return $query->steps_count;
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('task_flow.show', $row->id);
                $deleteUrl = route('task_flow.destroy', $row->id);
                $editButton = "<a href='$editUrl' class='btn btn-sm btn-info'>詳細內容</a>";
                $deleteButton = 
                // auth()->user()->can('update', $row) ? 
                    "<a onclick=\"confirmCancel(event, '$deleteUrl', $row->id)\" class='btn btn-sm btn-danger'>刪除流程</a>" 
                    // : ''
                    ;
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action']) // 確保 HTML 被正確渲染
            ->make(true);
        }

    }
}
