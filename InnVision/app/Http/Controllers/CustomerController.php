<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Branch;
use App\Models\Facility;
use App\Models\Room;

class CustomerController extends Controller
{
    // public function index()
    // {
    //     $hotels = Hotel::withCount('branches')->get();
    //     return view('customer.hotels.index', compact('hotels'));
    // }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $hotels = Hotel::withCount('branches')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return view('customer.hotels.index', compact('hotels', 'search'));
    }

    // public function showHotel($id)
    // {
    //     $hotel = Hotel::with('branches')->find($id);

    //     if (!$hotel) {
    //         return redirect()->route('customer.hotels.index')->with('error', 'Hotel not found.');
    //     }

    //     return view('customer.hotels.show', compact('hotel'));
    // }

    public function showBranch(Request $request, $id)
    {
        $branch = Branch::with('rooms', 'facilities')->find($id);

        if (!$branch) {
            return redirect()->route('customer.hotels.index')->with('error', 'Branch not found.');
        }

        // Fetch facilities related to the branch
        $facilities = Facility::all()->pluck('name', 'id');

        // Handle search functionality
        $query = $branch->rooms()->where('is_booked', false);

        if ($request->has('search')) {
            $query->where('room_number', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('facility')) {
            $query->whereHas('facilities', function($q) use ($request) {
                $q->where('name', $request->input('facility'));
            });
        }

        if ($request->has('min_fare') && $request->has('max_fare')) {
            $query->whereBetween('fare', [$request->input('min_fare'), $request->input('max_fare')]);
        }

        $rooms = $query->get();

        return view('customer.hotels.branchesshow', compact('branch', 'facilities', 'rooms'));
    }


    public function showHotel(Request $request, $id)
    {
        $hotel = Hotel::with(['branches.rooms'])->find($id);

        if (!$hotel) {
            return redirect()->route('customer.hotels.index')->with('error', 'Hotel not found.');
        }

        $search = $request->input('search');
        $facility = $request->input('facility');

        $branches = $hotel->branches()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->when($facility, function ($query, $facility) {
                return $query->whereHas('facilities', function ($q) use ($facility) {
                    $q->where('name', $facility);
                });
            })
            ->get();

        $facilities = Facility::pluck('name', 'id');

        return view('customer.hotels.show', compact('hotel', 'branches', 'facilities', 'search', 'facility'));
    }


    public function myBookings()
    {
        $userId = Auth::id();

        // Retrieve rooms where the customer_id matches the authenticated user's ID
        $rooms = Room::where('customer_id', $userId)->with(['branch.hotel', 'facilities'])->get();

        return view('customer.rooms.my_bookings', compact('rooms'));
    }

}
