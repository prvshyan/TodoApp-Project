<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>

<h1>Edit Task</h1>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li style="color: red;">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/tasks/{{ $task->id }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Task Name:</label>
    <input type="text" id="name" name="name" value="{{ $task->name }}" required>
    <br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description">{{ $task->description }}</textarea>
    <br><br>

    <button type="submit">Update Task</button>
</form>

<a href="/tasks">Back to Task List</a>

</body>
</html>
