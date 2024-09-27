<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <!-- Add your CSS or include any CDN links for Bootstrap, Tailwind, etc. -->
</head>
<body>
    <header>
        <nav>
            <!-- Admin Navigation -->
            <ul>
                <li><a href="{{ route('posts.index') }}">Manage Posts</a></li>
                <li><a href="{{ route('topics.index') }}">Manage Topics</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>

    <main>
        @yield('content') <!-- This is where page-specific content will go -->
    </main>

    <!-- Include JavaScript or any other scripts -->
    @yield('scripts')
</body>
</html>
