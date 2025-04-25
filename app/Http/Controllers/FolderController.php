<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    // Відображення списку папок
    public function index(Request $request)
    {
        // Отримуємо введення користувача для пошуку
        $search = $request->input('search');

        // Запит для отримання папок користувача
        $foldersQuery = Auth::user()->folders();

        // Якщо є пошуковий запит, фільтруємо по назві папки
        if ($search) {
            $foldersQuery->where('folder_name', 'LIKE', '%' . $search . '%');
        }

        // Отримуємо список папок
        $folders = $foldersQuery->get();

        // Повертаємо відповідь на сторінку з папками
        return view('folders.index', compact('folders', 'search'));
    }

    // Форма створення нової папки
    public function create()
    {
        return view('folders.create');
    }

    // Збереження нової папки
    public function store(Request $request)
    {
        // Валідуємо введені дані
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        // Створюємо нову папку для користувача
        Auth::user()->folders()->create([
            'folder_name' => $request->folder_name,
        ]);

        // Повертаємо на сторінку зі списком папок з повідомленням про успіх
        return redirect()->route('folders.index')->with('success', 'Папка створена успішно!');
    }

    // Відображення деталей папки
    public function show(Folder $folder)
    {
        // Авторизація, перевірка прав на доступ до цієї папки
        $this->authorize('view', $folder);

        // Отримуємо завдання, що належать цій папці
        $tasks = $folder->tasks()->where('user_id', Auth::id())->get();

        // Повертаємо вигляд для цієї папки з її завданнями
        return view('folders.show', compact('folder', 'tasks'));
    }

    // Форма редагування папки
    public function edit(Folder $folder)
    {
        // Авторизація, перевірка прав на редагування цієї папки
        $this->authorize('update', $folder);

        return view('folders.edit', compact('folder'));
    }

    // Оновлення даних папки
    public function update(Request $request, Folder $folder)
    {
        // Авторизація, перевірка прав на редагування цієї папки
        $this->authorize('update', $folder);

        // Валідуємо введені дані
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        // Оновлюємо назву папки
        $folder->update([
            'folder_name' => $request->folder_name,
        ]);

        // Повертаємо на сторінку зі списком папок з повідомленням про успіх
        return redirect()->route('folders.index')->with('success', 'Папка оновлена!');
    }

    // Видалення папки
    public function destroy(Folder $folder)
    {
        // Авторизація, перевірка прав на видалення цієї папки
        $this->authorize('delete', $folder);

        // Видаляємо папку
        $folder->delete();

        // Повертаємо на сторінку зі списком папок з повідомленням про успіх
        return redirect()->route('folders.index')->with('success', 'Папка видалена!');
    }
}
