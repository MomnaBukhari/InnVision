@extends('owner.ownerlayout')

@section('title', 'Pending Bookings')
{{--
@section('section1')
<h1>Pending Bookings for This Month</h1>
    <div id="pending-bookings">
        <p>Loading...</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/pending-bookings', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Adjust according to your token storage
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Bookings data:', data); // Check if data is fetched correctly

                const today = new Date();
                const currentMonth = today.getMonth(); // 0-based index for months
                const currentYear = today.getFullYear();

                // Filter bookings for the current month and year
                const filteredBookings = data.filter(booking => {
                    const bookingStartDate = new Date(booking.start_date);
                    return bookingStartDate.getMonth() === currentMonth && bookingStartDate.getFullYear() === currentYear;
                });

                // Generate HTML for the bookings
                let bookingsHtml = `
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Start Date</th>
                                <th>Duration</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                if (filteredBookings.length === 0) {
                    bookingsHtml += '<tr><td colspan="4">No pending bookings for this month.</td></tr>';
                } else {
                    filteredBookings.forEach(booking => {
                        bookingsHtml += `
                            <tr>
                                <td>${booking.room_number || 'N/A'}</td>
                                <td>${booking.start_date}</td>
                                <td>${booking.duration_days} days</td>
                                <td>${booking.total_price}</td>
                            </tr>
                        `;
                    });
                }

                bookingsHtml += '</tbody></table>';
                document.getElementById('pending-bookings').innerHTML = bookingsHtml;
            })
            .catch(error => {
                console.error('Error fetching bookings:', error);
                document.getElementById('pending-bookings').innerHTML = '<p>Error loading bookings.</p>';
            });
        });
    </script>
@endsection --}}
@section('section1')
<h1>Pending Bookings for {{ date('F Y') }}</h1>
<h1>Pending Bookings</h1>

    <table id="bookingsTable">
        <thead>
            <tr>
                <th>Room</th>
                <th>Start Date</th>
                <th>Duration</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr class="booking-row"
                    data-start-date="{{ $booking->start_date }}"
                    data-duration="{{ $booking->duration_days }}"
                    data-total-price="{{ $booking->total_price }}">
                    <td>{{ $booking->room->room_number }}</td>
                    <td>{{ $booking->start_date }}</td>
                    <td>{{ $booking->duration_days }} days</td>
                    <td>${{ $booking->total_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date();
            const currentMonth = today.getMonth(); // 0-based (January is 0)
            const currentYear = today.getFullYear();
            const currentDate = today.getDate();

            const rows = document.querySelectorAll('.booking-row');

            rows.forEach(row => {
                const startDate = new Date(row.dataset.startDate);
                const startMonth = startDate.getMonth();
                const startYear = startDate.getFullYear();
                const startDay = startDate.getDate();

                // Check if the start date is within the current month and year
                if (startYear === currentYear && startMonth === currentMonth) {
                    // Check if the start date is in the past
                    if (startDate < today) {
                        row.style.display = 'none'; // Hide rows that are in the past
                    }
                } else {
                    row.style.display = 'none'; // Hide rows not in the current month
                }
            });
        });
    </script>

@endsection
