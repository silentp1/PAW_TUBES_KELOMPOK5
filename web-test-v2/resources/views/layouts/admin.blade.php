<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineSpot Admin</title>
    <style>
        :root {
            --primary: #922c2c;
            /* Red specific for admin */
            --bg-light: #f4f4f4;
            --text-dark: #333;
        }

        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            display: flex;
            height: 100vh;
            background: var(--bg-light);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #222;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            margin-bottom: 40px;
            color: var(--primary);
            text-align: center;
        }

        .sidebar a {
            color: #ccc;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: 0.2s;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--primary);
            color: white;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>CINESPOT ADMIN</h2>
        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.movies.index') }}"
            class="{{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">Movies</a>
        <a href="{{ route('admin.theaters.index') }}"
            class="{{ request()->routeIs('admin.theaters.*') ? 'active' : '' }}">Theaters</a>
        <a href="{{ route('admin.locations.index') }}"
            class="{{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">Locations</a>
        <a href="{{ route('admin.schedules.index') }}"
            class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">Schedules</a>
        <a href="{{ route('admin.transactions.index') }}"
            class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">Transactions</a>
        <a href="{{ route('admin.analytics.index') }}"
            class="{{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">Analytics</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
            @csrf
            <button type="submit"
                style="background:none; border:none; color:#ccc; width:100%; text-align:left; padding:15px; cursor:pointer;">Logout</button>
        </form>
    </div>

    <div class="content">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

</body>

</html>