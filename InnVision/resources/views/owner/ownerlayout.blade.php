<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - InnVision</title>
    <link rel="favicon" link="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('stylesheets/style.css') }}">
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
            <a href="{{route('owner.dashboard')}}">Dashboard</a>
            <a href="{{route('profile.show')}}">Profile</a>
            <a href="{{route('owner.hotels.index')}}">Hotels</a>
            <a href="{{route('owner.branches.index')}}">Branches</a>
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