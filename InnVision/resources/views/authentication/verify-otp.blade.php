@extends('mainlayout')

@section('title')
    Verify OTP
@endsection

@section('pusherscript')
<script>
    function startCountdown(duration, display) {
        var timer = duration, minutes, seconds;
        var countdown = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(countdown);
                window.location.href = "{{ route('login') }}"; // Redirect to login page after timeout
            }
        }, 1000);
    }

    window.onload = function () {
        var countdownTime = 60; // 60 seconds countdown
        var display = document.querySelector('#countdown');
        startCountdown(countdownTime, display);
    };
</script>
@endsection

@section('section1')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                Time Out - <a href="{{route('login')}}">Go back</a> and Re-try
            </ul>
        </div>
    @endif

    <div id="countdown" style="text-align: center; font-size: 1.5em; margin-bottom: 1rem;"></div>

    <form method="POST" action="{{ route('verify-otp') }}" class="form-container">
        @csrf
        <div class="form-group">
            <label for="otp">Enter OTP:</label>
            <input type="text" name="otp" id="otp" class="form-control" required>
        </div>
        <input type="hidden" name="user_id" value="{{ session('user_id') }}">
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
@endsection

@section('style')
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 2% 0% 0% 0%;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: .5rem;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: .5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #0e0e0e;
            border: none;
            color: white;
            padding: .5rem 1rem;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
            margin: .5rem 0;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #ce0505;
        }

        .alert {
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
@endsection
