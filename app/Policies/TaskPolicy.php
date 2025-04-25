<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     *  чи користувач може переглядати список завдань
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     *  чи користувач може переглядати одне конкретне завдання
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     *  чи користувач може створювати завдання
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     *  чи користувач може оновлювати завдання
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     *  чи користувач може видаляти завдання
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     *  відновлення завдання
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     *  повне видалення
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}
