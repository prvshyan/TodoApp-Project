<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login-form')->withErrors(['error' => 'Please log in to access tasks.']);
        }

        $tasks = auth()->user()->tasks ?? [];

        return view('index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->tasks()->create([
            'name' => $request->name,
            'description' => $request->description,
            'completed' => false,
        ]);

        return redirect('/tasks')->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        if ($task->user_id !== auth()->id()) {
            return redirect('/tasks')->withErrors(['error' => 'You do not have permission to update this task.']);
        }

        $task->update([
            'completed' => $request->completed,
        ]);

        return redirect('/tasks')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return redirect('/tasks')->withErrors(['error' => 'You do not have permission to delete this task.']);
        }

        $task->delete();

        return redirect('/tasks')->with('success', 'Task deleted successfully!');
    }
}
