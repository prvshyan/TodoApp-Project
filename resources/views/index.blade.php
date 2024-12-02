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

<h3>Incomplete Tasks</h3>
<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($incompleteTasks as $task)
        <tr>
            <td>{{ $task->name }}</td>
            <td>{{ $task->description }}</td>
            <td>
                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Mark as Complete</button>
                </form>

                <form action="/tasks/{{ $task->id }}/edit" method="GET" style="display:inline;">
                    <button type="submit">Edit</button>
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

<h3>Completed Tasks</h3>
<table border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($completedTasks as $task)
        <tr>
            <td>{{ $task->name }}</td>
            <td>{{ $task->description }}</td>
            <td>
                <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit">Mark as Incomplete</button>
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
    <br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>
    <br><br>

    <button type="submit">Create Task</button>
</form>

</body>
</html>
