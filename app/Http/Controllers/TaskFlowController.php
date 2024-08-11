<?php

namespace App\Http\Controllers;

use App\Models\TaskFlowTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class TaskFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('task_flow.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('task_flow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info(['task_flow_store'=>$request->all()]);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskFlowTemplate $taskFlowTemplate)
    {
        //
        return view('task_flow.show');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskFlowTemplate $taskFlowTemplate)
    {
        //
        return view('task_flow.edit');
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
    public function destroy(TaskFlowTemplate $taskFlowTemplate)
    {
        //
    }
}
