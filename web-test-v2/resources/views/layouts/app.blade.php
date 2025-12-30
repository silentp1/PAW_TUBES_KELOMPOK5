<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineSpot - @yield('title', 'Home')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <div class="app-container">
        <div class="main-interface">
            <!-- Header -->
            <header>
                <div class="logo">
                    <a href="{{ url('/') }}" style="text-decoration:none; color:white;">CineSpot</a>
                </div>

                <div class="user-profile" style="display: flex; align-items: center;">
                    <!-- Customer Service Button -->
                    <a href="{{ route('customer_service') }}"
                        style="margin-right: 15px; display: flex; align-items: center; text-decoration: none;">
                        <img src="{{ asset('cs_new.png') }}" alt="CS"
                            style="width: 25px; height: 25px; opacity: 0.9; transition: 0.2s;"
                            onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.9">
                    </a>

                    <!-- Notification Button -->
                    <a href="{{ route('notification') }}"
                        style="margin-right: 15px; display: flex; align-items: center; text-decoration: none;">
                        <img src="{{ asset('notification_new.png') }}" alt="Notification"
                            style="width: 25px; height: 25px; opacity: 0.9; object-fit: contain; transition: 0.2s;"
                            onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.9">
                    </a>

                    @auth
                        <!-- Profile Button -->
                        <a href="{{ route('profile') }}"
                            style="margin-right: 15px; display: flex; align-items: center; text-decoration: none;">
                            <img src="{{ asset('profile_new.png') }}" alt="Profile"
                                style="width: 25px; height: 25px; object-fit: contain;">
                            <span style="margin-left: 10px; color: white;">{{ Auth::user()->name }}</span>
                        </a>


                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; color: white; cursor: pointer; font-weight: 700;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            style="color: white; font-weight: 600; margin-right: 15px; text-decoration: none;">Login</a>
                        <a href="{{ route('register') }}"
                            style="background: var(--primary); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none;">Register</a>
                    @endauth
                </div>
            </header>

            <!-- Main Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            <!-- Footer Card -->
            <div
                style="width: 100%; margin: 0; background: white; padding: 20px; border-radius: 0; box-shadow: 0 -4px 10px rgba(0,0,0,0.05); text-align: center;">
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                    Copyrights © 2025 Kelompok 5 Pengembangan Aplikasi Website - Telkom University Jakarta
                </p>
            </div>

        </div>
    </div>

    <script>
        // Global Scripts
    </script>
</body>

</html>