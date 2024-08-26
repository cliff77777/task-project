<?php

namespace App\Http\Controllers;

//model
use App\Models\TaskNote;

//service
use App\Services\ChartLineService; 

//other
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HomeController extends Controller
{

    protected $ChartLineService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ChartLineService $chartLineService,
    )
    {
        $this->middleware('auth');
        $this->ChartLineService = $chartLineService;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        Log::debug('home index');
        $view=$this->CheckMailVerifyForView($request);

        if($view !=='home'){
            return view($view);
        }
        $get_chart_data=$this->ChartLineService->chart_line_method();
        
        return view($view,compact('get_chart_data'));
    }

    public function getUserTasks(Request $request)
    {
        if ($request->ajax()) {
            // 加載任務數據
            $get_user_task = TaskNote::where('assign_to', auth()->id())
                ->with(['task', 'creator:id,name'])
                ->orderBy('status', 'asc');

            // 使用 Yajra DataTables 將數據轉換為 JSON 格式
            return DataTables::of($get_user_task)
                ->addColumn('subject', function ($taskNote) {
                    return $taskNote->task->subject;
                })
                ->addColumn('description', function ($taskNote) {
                    return $taskNote->task->description;
                })
                ->addColumn('estimated_hours', function ($taskNote) {
                    return $taskNote->task->estimated_hours;
                })
                ->addColumn('status', function ($taskNote) {
                    return $taskNote->status == 0 ? '未完成' : '已完成';
                })
                ->addColumn('creator_name', function ($taskNote) {
                    return $taskNote->creator->name;
                })
                ->addColumn('action', function ($taskNote) {
                    return '<a href="'.route('tasks.show', $taskNote->task_id).'" class="btn btn-sm btn-info text-white">前往</a>';
                })
                ->rawColumns(['action']) // 確保 HTML 被正確渲染
                ->make(true);
        }
    }
}
