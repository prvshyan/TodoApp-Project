<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
// لیست تسک‌ها
public function index(Request $request)
{
$tasks = $request->user()->tasks;

return response()->json([
'incompleteTasks' => $tasks->where('completed', false),
'completedTasks' => $tasks->where('completed', true),
]);
}

// ذخیره تسک جدید
public function store(Request $request)
{
$request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
]);

$task = $request->user()->tasks()->create([
'name' => $request->name,
'description' => $request->description,
'completed' => false,
]);

return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
}

// به‌روزرسانی تسک
public function update(Request $request, Task $task)
{
if ($task->user_id !== $request->user()->id) {
return response()->json(['message' => 'Unauthorized'], 403);
}

$request->validate([
'name' => 'required|string|max:255',
'description' => 'nullable|string',
'completed' => 'required|boolean',
]);

$task->update($request->only('name', 'description', 'completed'));

return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
}

// تغییر وضعیت تسک
public function toggleStatus(Request $request, Task $task)
{
if ($task->user_id !== $request->user()->id) {
return response()->json(['message' => 'Unauthorized'], 403);
}

$task->update(['completed' => !$task->completed]);

return response()->json(['message' => 'Task status updated successfully', 'task' => $task], 200);
}

// حذف تسک
public function destroy(Request $request, Task $task)
{
if ($task->user_id !== $request->user()->id) {
return response()->json(['message' => 'Unauthorized'], 403);
}

$task->delete();

return response()->json(['message' => 'Task deleted successfully'], 200);
}
}
