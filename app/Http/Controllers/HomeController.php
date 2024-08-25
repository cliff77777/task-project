<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//model
use App\Models\TaskNote;

//service
use App\Services\ChartLineService; 





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
        $get_user_task=TaskNote::where('assign_to',Auth::id())->with('task')
        ->with(['creator:id,name'])->orderby('status','asc')->get();

        return view($view,compact('get_chart_data','get_user_task'));
    }
}
