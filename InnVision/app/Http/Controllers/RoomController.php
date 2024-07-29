<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with(['branch.hotel', 'facilities', 'bookedBy'])->get();
        return view('owner.rooms.index', compact('rooms'));

    }

    public function create()
    {
        $branches = Branch::where('owner_id', Auth::id())->get();
        $facilities = Facility::all();
        $customers = User::where('role', 'customer')->get();
        return view('owner.rooms.create', compact('branches', 'facilities', 'customers'));
    }


    // Store a newly created room in storage
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:255|unique:rooms',
            'status' => 'required|in:available,booked',
            'booked_by' => 'nullable|string|max:255',
            'floor' => 'required|integer',
            'max_occupancy' => 'required|integer',
            'single_beds' => 'nullable|integer',
            'description' => 'nullable|string',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $room = Room::create($request->except('facilities'));

        // Attach the selected facilities to the room
        if ($request->has('facilities')) {
            $room->facilities()->attach($request->facilities);
        }

        return redirect()->route('owner.rooms.index')->with('success', 'Room created successfully.');
    }


    // Show the form for editing the specified room
    public function edit(Room $room)
    {
        $facilities = Facility::all();
        $customers = User::where('role', 'customer')->get();
        $branches = Branch::where('owner_id', Auth::id())->get();
        return view('owner.rooms.edit', compact('room', 'branches', 'customers', 'facilities'));
    }

    // Update the specified room in storage
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'status' => 'required|in:available,booked',
            'booked_by' => 'nullable|string|max:255',
            'floor' => 'required|integer',
            'max_occupancy' => 'required|integer',
            'single_beds' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $room->update($request->all());

        return redirect()->route('owner.rooms.index')->with('success', 'Room updated successfully.');
    }

    // Remove the specified room from storage
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('owner.rooms.index')->with('success', 'Room deleted successfully.');
    }

    // Book a room (this method would be used if you want to handle booking functionality directly)
    public function book(Request $request, Room $room)
    {
        $request->validate([
            'booked_by' => 'required|string|max:255',
        ]);

        if ($room->status == 'booked') {
            return redirect()->back()->with('error', 'Room is already booked.');
        }

        $room->update([
            'status' => 'booked',
            'booked_by' => $request->booked_by,
        ]);

        return redirect()->route('owner.rooms.index')->with('success', 'Room booked successfully.');
    }

    // Mark a room as available
    public function markAvailable(Room $room)
    {
        $room->update([
            'status' => 'available',
            'booked_by' => null,
        ]);

        return redirect()->route('owner.rooms.index')->with('success', 'Room marked as available.');
    }
}