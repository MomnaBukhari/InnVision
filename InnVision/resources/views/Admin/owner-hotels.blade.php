@extends('admin.adminlayout')

@section('title', $user->name . ' - Hotels')

@section('style')
    <style>
        .table-container {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background-color: #ffffff;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <a href="{{ route('admin.users') }}" class="side-menu-list-item side-menu-list-item-action">Goto Users</a>
            <a href="{{ route('admin.manage-approvals') }}" class="side-menu-list-item side-menu-list-item-action">Goto Approvals</a>
        </div>
        <div class="section1-part2">
            <div class="table-container">
                <h2>Hotels of {{ $user->name }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Hotel Name</th>
                            <th>Number of Branches</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->name }}</td>
                                <td>{{ $hotel->branches->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.viewHotel', $hotel->id) }}" class="btn btn-primary">View</a>
                                    <form action="{{ route('admin.deleteHotel', $hotel->id) }}" method="POST" style="display:inline;">
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
