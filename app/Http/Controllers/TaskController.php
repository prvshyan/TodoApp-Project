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

        $incompleteTasks = auth()->user()->tasks()->where('completed', false)->get();
        $completedTasks = auth()->user()->tasks()->where('completed', true)->get();

        return view('index', compact('incompleteTasks', 'completedTasks'));
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
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        if ($task->user_id !== auth()->id()) {
            return redirect('/tasks')->withErrors(['error' => 'You do not have permission to update this task.']);
        }

        $task->update($request->only('name', 'description', 'completed'));

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
    public function toggleStatus(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return redirect('/tasks')->withErrors(['error' => 'You do not have permission to update this task.']);
        }

        $task->completed = !$task->completed;
        $task->save();

        return redirect('/tasks')->with('success', 'Task status updated successfully!');
    }

}
