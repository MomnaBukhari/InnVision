@extends('customer.customerlayout')

@section('title', 'Book Room')

@section('section1')
<div class="container mt-5">
    <h1>Book Room - {{ $room->room_number }}</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('book.room', $room->id) }}" method="POST" id="booking-form">
        @csrf

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="duration_days">Duration (in days):</label>
            <input type="number" id="duration_days" name="duration_days" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="price">Price per Day:</label>
            <input type="text" id="price" class="form-control" value="${{ $room->fare }}" readonly>
        </div>

        <div class="form-group">
            <label for="total_price">Total Price:</label>
            <input type="text" id="total_price" class="form-control" value="${{ $room->fare }}" readonly>
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="text" id="end_date" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary" id="book_now_button">Book Now</button>
    </form>

    <div class="mt-3">
        <h5>Unavailable Dates:</h5>
        <ul id="unavailable_dates">
            @foreach($bookings as $booking)
                <li>From {{ $booking['start_date'] }} to {{ $booking['end_date'] }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        // Function to check if a date is unavailable
        function isDateUnavailable(date, unavailableDates) {
            return unavailableDates.some(range => {
                const startDate = new Date(range.start_date);
                const endDate = new Date(range.end_date);
                return date >= startDate && date <= endDate;
            });
        }

        const unavailableDates = @json($bookings);
        const bookNowButton = document.getElementById('book_now_button');

        function validateDates() {
            const startDateInput = document.getElementById('start_date');
            const durationDaysInput = document.getElementById('duration_days');
            const startDate = new Date(startDateInput.value);
            const durationDays = parseInt(durationDaysInput.value);
            const today = new Date();
            let endDate;

            if (startDateInput.value && durationDays > 0) {
                endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + durationDays);

                // Update end date field
                document.getElementById('end_date').value = endDate.toISOString().split('T')[0];

                // Check if start date is in the past
                if (startDate < today) {
                    alert('Start date cannot be in the past.');
                    bookNowButton.disabled = true;
                    return;
                }

                // Check if the selected range overlaps with unavailable dates
                const isUnavailable = isDateUnavailable(startDate, unavailableDates) || isDateUnavailable(endDate, unavailableDates);
                if (isUnavailable) {
                    alert('Selected dates are not available.');
                    bookNowButton.disabled = true;
                    return;
                }

                // Enable the button if dates are valid
                bookNowButton.disabled = false;
            } else {
                bookNowButton.disabled = true;
            }
        }

        document.getElementById('start_date').addEventListener('change', validateDates);
        document.getElementById('duration_days').addEventListener('input', validateDates);
    </script>
</div>
@endsection
