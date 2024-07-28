@extends('admin.adminlayout')

@section('title', 'Manage Users')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <!-- Side menu or other content can be placed here -->
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>Manage Users</h2>
                @if (session('success'))
                    <div
                        style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Accordion for users by role -->
                <div class="accordion">
                    @foreach (['admin', 'hotel_owner', 'customer'] as $role)
                        <div class="accordion-item">
                            <button class="accordion-button">{{ ucfirst($role) }}s</button>
                            <div class="accordion-content">
                                @php
                                    $filteredUsers = $users->where('role', $role);
                                @endphp

                                @if ($filteredUsers->isEmpty())
                                    <p>No users found for this role.</p>
                                @else
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                @if ($role === 'hotel_owner')
                                                    <th>Approval Status</th>
                                                    <th>Approve</th>
                                                @endif
                                                <th>Profile</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($filteredUsers as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    @if ($role === 'hotel_owner')
                                                        <td>
                                                            @if ($user->is_approved)
                                                                <p class="badge badge-success">Approved</p>
                                                            @elseif ($user->request_send)
                                                                <p class="badge badge-warning">Requested</p>
                                                            @else
                                                                <p class="badge badge-secondary">Not Requested Yet</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($user->is_approved)
                                                                <form action="{{ route('disapprove.user', $user->id) }}"
                                                                    method="POST" style="display: inline-block;"
                                                                    onsubmit="return confirm('Are you sure you want to disapprove this user?');">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-success">Dispprove</button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('approve.user', $user->id) }}"
                                                                    method="POST" style="display: inline-block;"
                                                                    onsubmit="return confirm('Are you sure you want to approve this user?');">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-success">Approve</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    @if ($role !== 'admin')
                                                        <td>
                                                            <a href="{{ route('admin.user.view', $user) }}"
                                                                class="btn btn-info">View Profile</a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('admin.users.delete', $user) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .accordion {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-button {
            background: #f5f5f5;
            border: none;
            padding: 10px;
            text-align: left;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .accordion-button:hover {
            background: #e0e0e0;
        }

        .accordion-content {
            display: none;
            padding: 10px;
            background: #fff;
            border-top: 1px solid #ddd;
        }

        .accordion-item {
            margin-bottom: 10px;
        }

        .accordion-item.active .accordion-content {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .btn-danger {
            background-color: #ce0505;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-danger:hover {
            background-color: #a40303;
        }

        .btn-success {
            background-color: #ecefd6;
            color: #000000;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-success:hover {
            background-color: #c8dfab;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: #000000;
        }

        .badge-success {
            background-color: #daf4e0;
            color: #000;
        }

        .badge-danger {
            background-color: #dc3545;
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.accordion-button');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var item = button.parentElement;
                    var content = item.querySelector('.accordion-content');

                    if (item.classList.contains('active')) {
                        item.classList.remove('active');
                        content.style.display = 'none';
                    } else {
                        document.querySelectorAll('.accordion-item').forEach(function(otherItem) {
                            otherItem.classList.remove('active');
                            otherItem.querySelector('.accordion-content').style.display =
                                'none';
                        });

                        item.classList.add('active');
                        content.style.display = 'block';
                    }
                });
            });
        });
    </script>
@endsection
