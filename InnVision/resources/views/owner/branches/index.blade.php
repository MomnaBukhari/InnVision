@extends('owner.ownerlayout')

@section('title', 'Branches')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.branchsubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                {{-- <h1>Branches</h1> --}}

                {{-- <a href="{{ route('owner.branches.create') }}" class="btn btn-primary mb-3">Add New Branch</a> --}}

                @if ($branches->isEmpty())
                    <p class="alert alert-warning">No branches found.</p>
                @else
                    @php
                        $hotels = $branches->groupBy('hotel.name');
                    @endphp

                    @foreach ($hotels as $hotelName => $hotelBranches)
                        <div class="accordion">
                            <div class="accordion-header">
                                <button class="accordion-toggle">{{ $hotelName }}</button>
                            </div>
                            <div class="accordion-content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Main Branch</th>
                                            <th>Facilities</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotelBranches as $branch)
                                            <tr>
                                                <td>{{ $branch->name }}</td>
                                                <td>{{ $branch->address }}</td>
                                                <td>{{ $branch->is_main ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    @if ($branch->facilities->isNotEmpty())
                                                        @foreach ($branch->facilities as $facility)
                                                            <span class="badge">{{ $facility->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-secondary">No Facilities</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('owner.branches.edit', $branch) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('owner.branches.destroy', $branch) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .accordion {
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .accordion-header {
            background-color: #f8f9fa;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .accordion-content {
            display: none;
            padding: 10px;
        }

        .accordion-content .table {
            width: 100%;
            border-collapse: collapse;
        }

        .accordion-content .table th,
        .accordion-content .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .accordion-content .table th {
            background-color: #f2f2f2;
        }

        .accordion-content .badge {
            background-color: #17a2b8;
            color: #fff;
            padding: 3px 6px;
            border-radius: 3px;
            margin-right: 5px;
        }

        .accordion-content .badge-secondary {
            background-color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .remove-custom-facility {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 2px 6px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const isVisible = content.style.display === 'block';
                document.querySelectorAll('.accordion-content').forEach(c => c.style.display = 'none');
                content.style.display = isVisible ? 'none' : 'block';
            });
        });
    </script>
@endsection
