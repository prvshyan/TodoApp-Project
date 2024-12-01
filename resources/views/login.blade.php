<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
<h2>Login Form</h2>

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

<form action="{{ url('/login') }}" method="POST">
    @csrf

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br><br>

    <button type="submit">Login</button>
</form>
</body>
</html>
