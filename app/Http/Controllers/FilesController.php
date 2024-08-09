<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    protected $fileService;

    public function __construct(
        FileService $fileService
        )
    {
        $this->fileService = $fileService;
    }

    public function download_file($file_path,$disk='public'){
        $fullFilePath = $disk.'/' . $file_path;

        if (Storage::exists($fullFilePath)) {
            $fileSize = Storage::size($fullFilePath); // 獲取文件大小（以字節為單位）
            Log::info(["file_size" => $fileSize]);

            return Storage::download($fullFilePath);
        }

        Log::error("Unable to retrieve the file_size for file at location: " . $fullFilePath);
        return abort(404, 'File not found');
    }

    public function delete_file($file_path, $disk = 'public')
    {
        $fullFilePath = $disk . '/' . $file_path;

        if (Storage::disk($disk)->exists($file_path)) {
            try {
                $this->executeInTransaction(function () use ($file_path, $disk, $fullFilePath) {
                    // 刪除數據庫記錄
                    $taskFile = TaskFile::where('file_path', $file_path)->firstOrFail();
                    $taskFile->delete();
                    // 刪除文件
                    Storage::disk($disk)->delete($fullFilePath);
                });
                return response()->json(['message' => 'File deleted successfully'], 200);
            } catch (\Exception $e) {
                Log::error('An error occurred while deleting the file: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while deleting the file'], 500);
            }
        } else {
            return response()->json(['error' => 'File not found'], 500);
        }
    }

    public function upload_file(){
        
    }
}
