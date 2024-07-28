<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - InnVision</title>
    <link rel="favicon" link="/favicon.ico">
    <link rel="stylesheet" href="./stylesheets/style.css">
    @yield('style')
    @yield('pusherscript')
</head>
<body>
<header>
    <div class="navbar">
        <div class="navbar1">
            <p><a href="/">Inn<span style="color: #ce0505">Vision</span></a></p>
        </div>
        <div class="navbar2">
            <a href="/">Home</a>
            <a href="{{route('about')}}">About</a>
            <a href="{{route('services')}}">Services</a>
            <a href="{{route('register')}}">Join</a>
        </div>
    </div>
</header>
@yield('section1')
@yield('script')
</body>


</html>
