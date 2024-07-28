@extends('mainlayout')

@section('title')
    LogIn
@endsection

@section('pusherscript')
@endsection

@section('section1')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="form-container">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <div class="already-registered">
            <p>Not Registered Yet? <a href="{{ route('register') }}">Register Now</a></p>
        </div>
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

        .already-registered {
            /*background-color: white;*/
            padding: 5% 1% 5% 1%;
        }

        .already-registered a {
            color: #ce0505;
            height: 300px;
            width: 400px;
        }
    </style>
@endsection
