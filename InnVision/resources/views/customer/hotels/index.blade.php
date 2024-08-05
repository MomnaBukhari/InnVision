@extends('customer.customerlayout')

@section('title')
    Customer
@endsection

@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('section1')
    <div class="container mt-5">
        <h1>Hotels</h1>
        @if ($hotels->isEmpty())
            <div class="alert alert-warning" role="alert">
                No hotels available.
            </div>
        @else
        <form method="GET" action="{{ route('customer.hotels.index') }}" class="form-inline mb-3">
            <input type="text" name="search" id="search" class="form-control w-25" placeholder="Search hotels..." value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
            <a href="{{ route('customer.hotels.index') }}" class="btn btn-secondary ml-2">Clear Search</a>
        </form>



            <div class="form-group">
                <label for="sortOptions">Sort by:</label>
                <select id="sortOptions" class="form-control w-25">
                    <option value="name">Name</option>
                    <option value="stars">Service (stars)</option>
                    <option value="location">Location</option>
                    <option value="branches_count">Branches (count)</option>
                </select>

            </div>

            <table class="table table-striped" id="hotelsTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Service (stars)</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Branches (count)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->stars }}</td>
                            <td>{{ $hotel->address }}</td>
                            <td>{{ $hotel->description }}</td>
                            <td>{{ $hotel->branches_count }}</td>
                            <td><a href="{{ route('customer.hotel.show', $hotel->id) }}" class="btn btn-primary">Proceed</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('sortOptions').addEventListener('change', function() {
            sortTable(this.value);
        });

        function sortTable(sortBy) {
            const table = document.getElementById('hotelsTable').getElementsByTagName('tbody')[0];
            const rows = Array.from(table.rows);

            let compare;
            switch (sortBy) {
                case 'name':
                    compare = (a, b) => a.cells[0].innerText.localeCompare(b.cells[0].innerText);
                    break;
                case 'stars':
                    compare = (a, b) => parseInt(a.cells[1].innerText) - parseInt(b.cells[1].innerText);
                    break;
                case 'location':
                    compare = (a, b) => a.cells[2].innerText.localeCompare(b.cells[2].innerText);
                    break;
                case 'branches_count':
                    compare = (a, b) => parseInt(a.cells[4].innerText) - parseInt(b.cells[4].innerText);
                    break;
                default:
                    return;
            }

            rows.sort(compare);

            while (table.firstChild) {
                table.removeChild(table.firstChild);
            }

            rows.forEach(row => table.appendChild(row));
        }
    </script>
@endsection
