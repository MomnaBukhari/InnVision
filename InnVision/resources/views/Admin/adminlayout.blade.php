<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - InnVision</title>
    <link rel="icon" link="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('stylesheets/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @yield('style')
    @yield('pusherscript')
</head>

<body>
    <header>
        <div class="innernav">
            <div class="innernav1">
                <p><a href="/">Inn<span style="color: #ce0505">Vision</span></a></p>
            </div>
            <div class="innernav2">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('profile.show') }}">Profile</a>
                <a href="{{ route('admin.users') }}">Users</a>
                <a href="{{ route('admin.manage-approvals') }}">Approvals</a>
                <a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </a>
            </div>
        </div>
    </header>
    @yield('section1')
    @yield('script')
</body>

</html>
