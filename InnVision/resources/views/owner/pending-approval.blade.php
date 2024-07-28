@extends('owner.ownerlayout')

@section('title', 'Pending Approval')

@section('section1')
    <div class="section1">
        <div class="section1-part1"></div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h1>Pending Approval</h1>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (Auth::check())
                    @if (Auth::user()->is_approved && Auth::user()->request_send)
                        <p>Your request is approved.</p>
                    @elseif(Auth::user()->request_send)
                        <p>Your request is sent. Please wait for admin approval.</p>
                        <form action="{{ route('owner.cancelRequest') }}" method="POST">
                            @csrf
                            <button type="submit">Cancel Request</button>
                        </form>
                    @else
                        <p>Your account is pending approval by the admin. Please wait until your account is approved to
                            access all features.</p>
                        <button id="requestApprovalBtn">Request Approval</button>

                        <form method="POST" id="approvalForm" action="{{ route('owner.requestApproval') }}" style="display: none;">
                            @csrf
                            @method('POST')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <label for="contact_number">Contact Number:</label>
                                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                            </div>
                            <div>
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                            </div>
                            <div>
                                <label for="about">About:</label>
                                <textarea id="about" name="about" required>{{ old('about') }}</textarea>
                            </div>
                            <div>
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="hotel_stars">Hotel Stars:</label>
                                <input type="number" id="hotel_stars" name="hotel_stars" value="{{ old('hotel_stars') }}" min="1" max="7" required>
                            </div>
                            <div>
                                <label for="service_class">Service Class:</label>
                                <select id="service_class" name="service_class" required>
                                    <option value="elite" {{ old('service_class') == 'elite' ? 'selected' : '' }}>Elite</option>
                                    <option value="middle" {{ old('service_class') == 'middle' ? 'selected' : '' }}>Middle</option>
                                    <option value="lower" {{ old('service_class') == 'lower' ? 'selected' : '' }}>Lower</option>
                                    <option value="general" {{ old('service_class') == 'general' ? 'selected' : '' }}>General</option>
                                    <option value="other" {{ old('service_class') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <button type="submit">Submit Request</button>
                        </form>
                    @endif
                @else
                    <p>You need to be logged in to view this page.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('requestApprovalBtn').addEventListener('click', function() {
            document.getElementById('approvalForm').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
@endsection
