<?php

namespace App\Http\Controllers;

// model
use App\Models\User;

//other 
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;





class ActivityLogController extends Controller
{
    public function index()
    {
        return view('activity_log.index');
    }

    public function getActivityTable(Request $request){
        if($request->ajax()){

            // $query = Activity::with('user');

            $query = DB::table('activity_log')->leftJoin('users', 'activity_log.causer_id', '=', 'users.id')
            ->select([
                'activity_log.id',
                'activity_log.description',
                'activity_log.subject_type',
                'activity_log.subject_id',
                'activity_log.causer_type',
                'activity_log.causer_id',
                'users.name as causer_name', // 使用 users.name 並起別名
                'activity_log.properties',
                'activity_log.created_at'
            ]);

            // 使用 DataTables 處理數據
            return DataTables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })
            ->addColumn('description', function ($query) {
                return $query->description;
            })
            ->addColumn('subject_type', function ($query) {
                return $query->subject_type;
            })
            ->addColumn('subject_id', function ($query) {
                return $query->subject_id;
            })
            ->addColumn('causer_type', function ($query) {
                
                return $query->causer_type ?? 'System Default';
            })
            ->addColumn('causer_id', function ($query) {
                return $query->causer_id ?? 'System Default';
            })
            ->addColumn('name', function ($query) {
                return $query->user->name ?? 'System Default';
            })
            ->addColumn('properties', function ($query) {
                return json_encode($query->properties);
            })
            ->addColumn('created_at', function ($query) {
                return $query->created_at;
            })
            ->make(true);
        }

    }
}
