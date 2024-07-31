<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\FileService;


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
        $tasks = Task::with('creator', 'assignee')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        Log::debug('in store');
        
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_hours' => 'required|numeric',
        ]);

        $task=Task::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'estimated_hours' => $request->estimated_hours,
            'created_by' => Auth::id(),
        ]);

        if($request->hasFile('file')){
            $file_path = $this->fileService->saveFileToTaskFile($request->file('file'), 'taskfile/'.$task->id,$task->id);
            $task->files()->saveMany($file_path);
            if (is_array($file_path) && isset($file_path['error'])) {
                return back()->withErrors($file_path['error']);
            }
        }

        return redirect()->route('tasks.index')->with('success', '工作單已創建');
    }

    public function show(Task $task)
    {
        Log::debug('in show');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'note' => 'nullable|string',
            'actual_hours' => 'nullable|numeric',
        ]);

        $task->update([
            'note' => $request->note,
            'actual_hours' => $request->actual_hours,
        ]);

        return redirect()->route('tasks.show', $task->id)->with('success', '工作單已更新');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', '工作單已刪除');
    }


}
