<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;

class TaskFileController extends Controller
{
    protected $fileService;

    public function __construct(
        FileService $fileService
        )
    {
        $this->fileService = $fileService;
    }

    public function store(Request $request, Task $task)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->withErrors('Please provide a file.');
        }


        $response_result = $this->fileService->saveFile($file, 'uploads');


        if (is_array($response_result) && isset($response_result['error'])) {
            return back()->withErrors($response_result['error']);
        }

        $this->create($response_result,$task->id);
    
        return back()->withSuccess('File uploaded successfully to: ' . $response_result);
    }

    public function create($path,$task_id)
    {
        TaskFile::create([
            'task_id' => $task_id,
            'file_path' => $path,
        ]);
    }
}
