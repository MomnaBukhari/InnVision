<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Facility;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Retrieve rooms where the branch's owner_id matches the authenticated user's ID
        $rooms = Room::whereHas('branch', function ($query) use ($userId) {
            $query->where('owner_id', $userId);
        })->with(['branch.hotel', 'facilities', 'currentBooking', 'bookedBy'])->get();

        return view('owner.rooms.index', compact('rooms'));
    }


    public function create()
    {
        $branches = Branch::where('owner_id', Auth::id())->get();
        $facilities = Facility::all();
        $customers = User::where('role', 'customer')->get();
        $hotels = Hotel::where('owner_id', Auth::id())->get();
        return view('owner.rooms.create', compact('branches', 'facilities', 'customers', 'hotels'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:255|unique:rooms',
            'customer_id' => 'nullable|exists:users,id',
            'floor' => 'required|integer',
            'max_occupancy' => 'required|integer',
            'single_beds' => 'nullable|integer',
            'fare' => 'required|numeric',
            'description' => 'nullable|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $roomData = $request->except('facilities');
        $roomData['is_booked'] = $request->has('customer_id') ? true : false;

        $room = Room::create($roomData);

        // Attach the selected facilities to the room
        if ($request->has('facilities')) {
            $room->facilities()->attach($request->facilities);
        }

        return redirect()->route('owner.rooms.index')->with('success', 'Room created successfully.');
    }



    public function edit(Room $room)
    {
        $facilities = Facility::all();
        $customers = User::where('role', 'customer')->get();
        $branches = Branch::where('owner_id', Auth::id())->get();
        $hotels = Hotel::where('owner_id', Auth::id())->get(); // Add this line to fetch hotels

        return view('owner.rooms.edit', compact('room', 'branches', 'customers', 'facilities', 'hotels'));
    }



    public function update(Request $request, Room $room)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'customer_id' => 'nullable|exists:users,id',
            'floor' => 'required|integer',
            'max_occupancy' => 'required|integer',
            'single_beds' => 'nullable|integer',
            'fare' => 'numeric',
            'description' => 'nullable|string',
            'status' => 'required|string|in:available,booked',
            'booked_by' => 'nullable|exists:users,id',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $roomData = $request->except('facilities');
        $roomData['is_booked'] = $request->input('status') === 'booked';
        $roomData['customer_id'] = $request->input('status') === 'booked' ? $request->input('booked_by') : null;

        $room->update($roomData);

        if ($request->has('facilities')) {
            $room->facilities()->sync($request->facilities);
        } else {
            $room->facilities()->detach(); // Remove all facilities if none selected
        }

        // Clear bookings if the room is marked as available
        if (!$room->is_booked) {
            $room->bookings()->delete();
        }

        return redirect()->route('owner.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room) // Remove the specified room
    {
        $room->delete();
        return redirect()->route('owner.rooms.index')->with('success', 'Room deleted successfully.');
    }

    // Book a room (this method would be used if you want to handle booking functionality directly)
    public function book(Request $request, Room $room)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
        ]);

        if ($room->is_booked) {
            return redirect()->back()->with('error', 'Room is already booked.');
        }

        $room->update([
            'is_booked' => true,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->route('owner.rooms.index')->with('success', 'Room booked successfully.');
    }

    public function getBranchesByHotel($hotelId)
    {
        $branches = Branch::where('hotel_id', $hotelId)->get();
        return response()->json($branches);
    }



    public function markAvailable(Room $room)
{
    $room->update([
        'is_booked' => false,
        'customer_id' => null,
    ]);

    // Remove bookings when marking as available
    $room->bookings()->delete();

    return redirect()->route('owner.rooms.index')->with('success', 'Room marked as available.');
}

}
