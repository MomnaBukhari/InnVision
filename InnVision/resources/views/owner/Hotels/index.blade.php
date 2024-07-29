@extends('owner.ownerlayout')

@section('title', 'My Hotels')

@section('style')
<style>


    h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        color: #333;
    }

    td {
        background-color: #ffffff;
    }

    tr:nth-child(even) td {
        background-color: #f9f9f9;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        color: #fff;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .notsetyet {
        color: gray;
    }
</style>
@endsection

@section('section1')
<div class="section1">
    <div class="section1-part1">
        @include('Owner.Ownercomponents.hotelsubmenu')
    </div>
    <div class="section1-part2">
        <div class="section1-part2-display">
            <h1>My Hotels</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Address</th>
                        <th>Stars</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->description }}</td>
                            <td>{{ $hotel->address }}</td>
                            <td>{{ $hotel->stars }}</td>
                            <td>
                                <a href="{{ route('owner.hotels.edit', $hotel->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('owner.hotels.destroy', $hotel->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
