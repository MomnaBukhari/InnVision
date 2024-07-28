@extends('customer.customerlayout')

@section('title', 'Profile')

@section('style')
    <style>
        .notsetyet {
            color: gray;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <img src="{{ $user->profile_picture ? $user->profile_picture : '/images/default_profile_picture.jpg' }}"
                alt="{{ $user->name }}'s Profile Picture" style="width: 150px; height: 150px; border-radius: 50%;">
            @include('Customer.Customercomponents.profilesubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>Profile Information</h2>

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>

                @if ($user->contact_number)
                    <p><strong>Contact Number:</strong> {{ $user->contact_number }}</p>
                @else
                    <p><strong>Contact Number:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                @if ($user->address)
                    <p><strong>Address:</strong> {{ $user->address }}</p>
                @else
                    <p><strong>Address:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                @if ($user->about)
                    <p><strong>About:</strong> {{ $user->about }}</p>
                @else
                    <p><strong>About:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                <!-- Add any other profile information you want to display -->

                <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('delete-account-form');

            if (deleteForm) {
                deleteForm.addEventListener('submit', function(event) {
                    const confirmation = confirm('Are you sure you want to delete your account? This action cannot be undone.');

                    if (!confirmation) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection
