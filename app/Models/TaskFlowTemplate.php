<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class TaskFlowTemplate extends Model
{
    use HasFactory,Notifiable;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'task_flow_name',
        'created_by',
        'updated_by'
    ];

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    static function save_date($data){
        $template = new self;

        // 使用填充數組設置模型屬性
        $template->task_flow_name = $data['flow_name'];
        $template->created_by = Auth::id();
        $template->updated_by = Auth::id();

        // 保存模型
        $template->save();

        Log::info("save_flow_template id: " . $template->id);

        return $template;
    }

    static function destroy_template($id){
        $template = self::find($id);
        if ($template) {
            // 記錄要刪除的模板 ID
            Log::info("destroy_template id: " . $template->id);
            // 刪除該記錄
            $template->delete();
        } else {
            // 如果未找到記錄，可以記錄一個錯誤或警告
            Log::warning("destroy_template failed: Template with id " . $id . " not found.");
        }
    
        return $template;
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function steps(){
        return $this->hasMany(TaskFlowSteps::class,'task_flow_template_id');
    }

    public function stepsWithRole()
    {
        return $this->hasMany(TaskFlowSteps::class, 'task_flow_template_id')->with('role');
    }

    public function first_order()
    {
        return $this->hasOne(TaskFlowSteps::class, 'task_flow_template_id',)->orderBy('order', 'asc');
    }

    public function getAssignedUsers()
    {
        $response = [];
        $type = 'success';
        if ($this->first_order) {
            $first_order_role = $this->first_order['to_role'];
            $role_user = User::where('role', $first_order_role)->pluck('name', 'id')->all();
            if (!empty($role_user)) {
                $user_count = 1;
                foreach ($role_user as $id => $name) {
                    $response[$user_count]['id'] = $id;
                    $response[$user_count]['name'] = $name;
                    $user_count++;
                }
            } else {
                $type = 'error';
                $response = 'No users found for the given role.';
            }
        } else {
            $type = 'error';
            $response = 'First step cannot find user.';
            Log::warning('First order not found for task flow template ID: ' . $this->id);
        }

        return ['type' => $type, 'response' => $response];
    }
}
