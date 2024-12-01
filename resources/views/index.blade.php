<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>

<h1>Task Manager</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li style="color: red;">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<h2>Your Tasks</h2>
<table border="1" cellpadding="10">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Completed</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <td>{{ $task->name }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->completed ? 'Yes' : 'No' }}</td>
            <td>
                <!-- فرم تغییر وضعیت تکمیل -->
                <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="completed" value="{{ $task->completed ? 0 : 1 }}">
                    <button type="submit">
                        {{ $task->completed ? 'Mark as Incomplete' : 'Mark as Complete' }}
                    </button>
                </form>

                <form action="/tasks/{{ $task->id }}/edit" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $task->name }}" required>
                    <textarea name="description">{{ $task->description }}</textarea>
                    <button type="submit" style="background-color: orange;">Edit</button>
                </form>

                <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: red; color: white;">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Create New Task</h2>
<form action="/tasks" method="POST">
    @csrf
    <label for="name">Task Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>

    <button type="submit">Create Task</button>
</form>

</body>
</html>
