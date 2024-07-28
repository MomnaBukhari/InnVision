@extends('admin.adminlayout')

@section('title', 'Approvals')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h1>Manage User Approvals</h1>
                @if (session('success'))
                    <div
                        style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif

                @php
                    $hasUnapprovedUsers = $users->isNotEmpty();
                @endphp

                @if (!$hasUnapprovedUsers)
                    <div class="alert alert-info" role="alert">
                        No Approval Requests
                    </div>
                @else
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->description }}</td>
                                    <td>
                                        <form action="{{ route('approve.user', $user->id) }}" method="POST"
                                            style="display: inline-block;"
                                            onsubmit="return confirm('Are you sure you want to approve this user?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('reject.user', $user->id) }}" method="POST"
                                            style="display: inline-block;"
                                            onsubmit="return confirm('Are you sure you want to reject this user?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                        <a href="{{ route('admin.user.view', $user->id) }}" class="btn btn-info">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
