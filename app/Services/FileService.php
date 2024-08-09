<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\TaskFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;



class FileService
{
    // protected ?UploadedFile $file = null;

    public function saveFileToTaskFile($file, $directory, $task_id)
    {
        Log::debug('saveFileToTaskFile', ['file' => $file, 'directory' => $directory, 'task_id' => $task_id]);
    
        $allowedMimeTypes = config('filesystems.allowed_file_type');
        $allowedMaxSize = config('filesystems.allowed_max_size', 2048);  // 以 KB 為單位

    
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
            $file_name=$file->getClientOriginalName();
            $path = $file->store($directory, 'public');
            $file_record = $this->createFileRecord($path, $task_id,$file_name);
    
            if (isset($file_record['error'])) {
                return $file_record;
            }
    
            return [$file_record];
        }
    
        return [
            'error' => 'No valid file uploaded.'
        ];
    }
    
    protected function createFileRecord($path, $task_id,$file_name)
    {
        try {
            return TaskFile::create([
                'task_id' => $task_id,
                'file_path' => $path,
                'file_name'=>$file_name
            ]);
        } catch (\Exception $e) {
            return [
                'error' => "Failed to save the file: " . $e->getMessage()
            ];
        }
    }
    
}