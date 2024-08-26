<?php
namespace App\Services;

//model
use App\Models\TaskNote;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;





class ChartLineService
{
    public function chart_line_method($method='last_7_days'){
        switch($method){
            case 'last_7_days':
                $response=$this->last_7_days();
                break;
        }
        
        return $response;
    }

    public function last_7_days(){
        $labels = [];

        $startDate = Carbon::now()->subDays(6)->startOfDay(); // 6 天前的開始
        $endDate = Carbon::now()->endOfDay(); // 今天的結束

        $user_id=Auth::id();
        
        $data=[
            'data1'=>[0,0,0,0,0,0,0],
            'data2'=>[0,0,0,0,0,0,0]
        ];

        $cableName=['cableName1'=>'總任務','cableName2'=>'被指派任務'];

        $task_total = TaskNote::select(
            DB::raw('DATE(created_at) as date'), // 只取日期部分
            DB::raw('COUNT(*) as total') // 統計每天的記錄數量
            )
            ->whereBetween('created_at', [$startDate, $endDate]) // 篩選最近七天的資料
            ->groupBy('date') // 按日期分組
            ->orderBy('date') // 按日期排序
            ->get();

            $user_task_total = TaskNote::select(
                DB::raw('DATE(created_at) as date'), // 只取日期部分
                DB::raw('COUNT(*) as total') // 統計每天的記錄數量
                )
                ->whereBetween('created_at', [$startDate, $endDate]) // 篩選最近七天的資料
                ->where('assign_to',$user_id)
                ->groupBy('date') // 按日期分組
                ->orderBy('date') // 按日期排序
                ->get();

            for ($i = 0; $i < 7; $i++) {
                $currentDate = $startDate->copy()->addDays($i);
                $labels[$i]=$currentDate->toDateString(); // 每天的日期
                 // 填充總任務數據
                $total_task = $task_total->firstWhere('date', $labels[$i]);
                $data['data1'][$i] = $total_task ? $total_task->total : 0;

                // 填充用戶任務數據
                $user_task = $user_task_total->firstWhere('date', $labels[$i]);
                $data['data2'][$i] = $user_task ? $user_task->total : 0;
            }
            
            return ['labels'=>$labels,'data'=>$data,'cableName'=>$cableName];
    }

    
}
