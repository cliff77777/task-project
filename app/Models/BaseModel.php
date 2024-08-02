<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class BaseModel extends Model
{
    use LogsActivity;

    // 設定要記錄的屬性，根據實際情況調整
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    // 自訂操作紀錄的名稱，可以根據實際情況調整
    protected static $logName = 'default';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName(static::$logName)
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => $this->getDescriptionForEvent($eventName));
    }
}
