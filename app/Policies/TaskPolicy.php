<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        // 任何用戶都可以查看任務
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // 只有具有 'admin' 或 'manager' 角色的用戶可以創建任務
        return $user->role === 'admin' || $user->role === 'manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        // 只有任務的創建者或 'admin' 角色的用戶可以更新任務
        return $user->id === $task->created_by || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // 只有 'admin' 角色的用戶可以刪除任務
        return $user->role === 'admin';
    }

    public function edit(User $user): bool
    {
        // 只有具有 'admin' 或 'manager' 角色的用戶可以創建任務
        return $user->role === 'admin' || $user->role === 'manager';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        //
    }
}
