<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Log;


class FileService
{

    public function saveFileToTaskFile($file, $directory, $task_id)
    {
        Log::debug('saveFileToTaskFile', ['file' => $file, 'directory' => $directory, 'task_id' => $task_id]);
    
        $allowedMimeTypes = config('filesystems.allowed_file_type');
        $allowedMaxSize = config('filesystems.allowed_max_size', 2048);  // 以 KB 為單位

        Log::debug('saveFileToTaskFile', ['allowedMimeTypes' => $allowedMimeTypes, 'allowedMaxSize' => $allowedMaxSize]);

    
        if ($file instanceof UploadedFile) {
            if (!in_array($file->getClientMimeType(), $allowedMimeTypes)) {
                return [
                    'error' => "Invalid file type."
                ];
            }
    
            // 檢查檔案大小
            if ($file->getSize() > $allowedMaxSize * 1024) {
                return [
                    'error' => "File too large. Maximum size is {$allowedMaxSize} KB."
                ];
            }
    
            $path = $file->store($directory, 'public');
            $file_record = $this->createFileRecord($path, $task_id);
    
            if (isset($file_record['error'])) {
                return $file_record;
            }
    
            return [$file_record];
        }
    
        return [
            'error' => 'No valid file uploaded.'
        ];
    }
    
    protected function createFileRecord($path, $task_id)
    {
        // 儲存檔案到指定路徑並返回儲存的路徑或文件名
        try {
            return TaskFile::create([
                'task_id' => $task_id,
                'file_path' => $path
            ]);
        } catch (\Exception $e) {
            return [
                'error' => "Failed to save the file: " . $e->getMessage()
            ];
        }
    }
    
}