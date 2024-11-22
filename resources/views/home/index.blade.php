<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to the Dashboard!</h1>
        <a href="{{ route('login.logout') }}" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>

</html>