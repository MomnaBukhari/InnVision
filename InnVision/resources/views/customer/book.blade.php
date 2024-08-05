<!-- resources/views/customer/book.blade.php -->
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

    <form action="{{ route('book.room', $room->id) }}" method="POST">
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

        <button type="submit" class="btn btn-primary">Book Now</button>
    </form>

    <script>
        document.getElementById('duration_days').addEventListener('input', function() {
            var days = this.value;
            var pricePerDay = parseFloat(document.getElementById('price').value.replace('$', ''));
            var totalPrice = days * pricePerDay;
            document.getElementById('total_price').value = '$' + totalPrice.toFixed(2);
        });
    </script>
</div>
@endsection
