<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Вивести всі завдання користувача
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        if ($request->filled('task_name')) {
            $query->where('task_name', 'LIKE', '%' . $request->task_name . '%');
        }

        if ($request->filled('folder_id')) {
            $query->where('folder_id', $request->folder_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('deadline')) {
            $query->whereDate('deadline', $request->deadline);
        }

        $tasks = $query->with('folder')->get();
        $folders = Auth::user()->folders;

        return view('tasks.index', [
            'tasks' => $tasks,
            'folders' => $folders,
            'filters' => $request->only(['task_name', 'folder_id', 'status', 'priority', 'deadline']),
        ]);
    }

    // Форма для створення нового завдання
    public function create()
    {
        $folders = Auth::user()->folders;
        return view('tasks.create', compact('folders'));
    }

    // Збереження нового завдання
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'folder_id' => 'required|exists:folders,id',
            'status' => 'required|in:Очікує,У процесі,Завершено',
            'priority' => 'required|in:Низький,Середній,Високий',
            'deadline' => 'nullable|date',
        ]);

        Auth::user()->tasks()->create([
            'task_name' => $request->task_name,
            'task_description' => $request->task_description,
            'folder_id' => $request->folder_id,
            'status' => $request->status,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Завдання створено успішно!');
    }

    // Форма редагування завдання
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $folders = Auth::user()->folders;
        return view('tasks.edit', compact('task', 'folders'));
    }

    // Оновлення завдання
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'folder_id' => 'required|exists:folders,id',
            'status' => 'required|in:Очікує,У процесі,Завершено',
            'priority' => 'required|in:Низький,Середній,Високий',
            'deadline' => 'nullable|date',
        ]);

        $task->update([
            'task_name' => $request->task_name,
            'task_description' => $request->task_description,
            'folder_id' => $request->folder_id,
            'status' => $request->status,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Завдання оновлене!');
    }

    // Видалення завдання
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Завдання видалене!');
    }
}
