@extends('mainlayout')

@section('title')
    Verify OTP
@endsection

@section('pusherscript')
@endsection

@section('section1')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                Time Out - <a href="{{route('login')}}">Go back</a> and Re-try
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
            </ul>
        </div>
    @endif

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
            /*background-color: #f9f9f9;*/
            /*border-radius: 5px;*/
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);*/
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
