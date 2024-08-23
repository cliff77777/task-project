<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\User; 
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;





class MailService
{
/**
     * 發送通知信件
     * @param  string  $type
     * @param  array  $details
     * @param  string  $assign_id
     * @return void
     */
    public function sendNotificationMail(string $type,array $data, string $assign_id)
    {
        $details=$this->set_detail($type,$data);
        $get_mail=User::find($assign_id)['email'];

        // 使用 queue 發送信件
        Mail::to($get_mail)->queue(new NotificationMail($details));
    }

    public function set_detail($type,$data){
        switch($type){
            case 'sendEmailNotification_first':
            $details = [
                'subject' => 'TaskProject Task Notification Email',
                'title' => '任務通知信件',
                'body' => $data['description'],
                'url' => env('APP_URL').'/tasks'.'/'.$data['task_id'],
                'actionText'=>'立即前往'
            ];
            break ;
            case 'sendEmailNotification':
                $details = [
                    'subject' => 'TaskProject Task Notification Email',
                    'title' => '任務通知信件',
                    'body' => $data['note'],
                    'url' => env('APP_URL').'/task'.'/'.$data['task_id'],
                    'actionText'=>'立即前往'
                ];
                break ;
        }

        return $details;
        
    }

}