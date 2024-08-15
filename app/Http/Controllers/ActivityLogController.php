<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Log;
use App\Models\User;



class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with('user')->latest()->paginate(10);

        Log::info(['activities'=>$activities]);

        return view('activity_log.index', compact('activities'));
    }
}
