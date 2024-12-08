<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ApiTaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $tasks = auth()->user()->tasks()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->paginate($perPage);

        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = auth()->user()->tasks()->create([
            'name' => $request->name,
            'description' => $request->description,
            'completed' => false,
        ]);

        return response()->json(['message' => 'Task created successfully!', 'task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        $task->update($request->only('name', 'description', 'completed'));

        return response()->json(['message' => 'Task updated successfully!', 'task' => $task], 200);
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!'], 200);
    }

    public function toggleStatus(Task $task)
    {
        $this->authorizeTask($task);

        $task->update(['completed' => !$task->completed]);

        return response()->json(['message' => 'Task status updated!', 'task' => $task], 200);
    }

    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
