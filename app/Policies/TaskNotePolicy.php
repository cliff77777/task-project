<?php

namespace App\Policies;

use App\Models\TaskNote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskNotePolicy
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
    public function view(User $user, TaskNote $taskNote): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskNote $taskNote): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaskNote $taskNote): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TaskNote $taskNote): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TaskNote $taskNote): bool
    {
        //
    }

    public function handel_step(User $user,TaskNote $task_note): bool
    {
        // 只有任務的創建者或 'admin' 角色的用戶可以更新任務
        return $user->id == $task_note->assign_to  || $user->role == '1';
    }
}
