
<!DOCTYPE html>
<html>
<head>
    <title>Voting System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Voting System</a>
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>