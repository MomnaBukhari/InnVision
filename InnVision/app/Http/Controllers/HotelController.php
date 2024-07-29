<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::where('owner_id', Auth::id())->get();
        return view('owner.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('owner.hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'stars' => 'nullable|integer|min:1|max:7',
        ]);

        Hotel::create([
            'owner_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'stars' => $request->stars,
        ]);

        return redirect()->route('owner.hotels.index')->with('success', 'Hotel created successfully.');
    }

  public function edit($id)
    {
        $hotel = Hotel::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        return view('owner.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'stars' => 'nullable|integer|min:1|max:7',
        ]);

        $hotel->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'stars' => $request->stars,
        ]);

        return redirect()->route('owner.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        $hotel->delete();
        return redirect()->route('owner.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
