<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\TaskFile;


class FileService
{

    public function saveFileToTaskFile($files, $directory,$task_id)
    {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf','form-data/xls'];
        $allowedMaxSize = 2048;  // 以 KB 為單位
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
            $file->validate([
                'file' => 'required|file|mimes:jpg,png,pdf,doc,docx,xls,xlsx,zip',
            ]);

            if (!in_array($file->getClientMimeType(), $allowedMimeTypes)) {
                return [
                    'error' => "Invalid file type. Allowed types are JPEG, PNG, PDF."
                ];
            }

             // 檢查檔案大小
             if ($file->getSize() > $allowedMaxSize * 1024) {
                return [
                    'error' => "File too large. Maximum size is {$allowedMaxSize} KB."
                ];
            }
                $path = $file->store($directory, 'public');
                $paths[] = $this->createFileRecord($path,$task_id);
            }
        }
        return $paths;

    }

    protected function createFileRecord($path,$task_id)
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