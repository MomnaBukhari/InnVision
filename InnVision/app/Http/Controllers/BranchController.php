<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Hotel;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{

    public function index()
    {
        $hotels = Hotel::where('owner_id', Auth::id())->get();
        $branches = Branch::whereIn('hotel_id', $hotels->pluck('id'))
            ->with('facilities') // Eager load facilities
            ->get();
        return view('owner.branches.index', compact('branches'));
    }


    public function create()
    {
        $hotels = Hotel::where('owner_id', Auth::id())->get();
        $staticFacilities = Facility::all();
        return view('owner.branches.create', compact('hotels', 'staticFacilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'is_main' => 'required|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'custom_facilities' => 'nullable|array',
            'custom_facilities.*' => 'string|max:150',
        ]);

        $facilities = $request->input('facilities', []);
        $customFacilities = $request->input('custom_facilities', []);

        foreach ($customFacilities as $customFacility) {
            $facility = Facility::firstOrCreate(['name' => $customFacility]);
            $facilities[] = $facility->id;
        }

        $branch = Branch::create([
            'hotel_id' => $request->hotel_id,
            'name' => $request->name,
            'address' => $request->address,
            'is_main' => $request->is_main,
        ]);

        if (!empty($facilities)) {
            $branch->facilities()->sync($facilities);
        }

        return redirect()->route('owner.branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit($id)
    {
        // Find the branch by its ID
        $branch = Branch::findOrFail($id);
        $hotels = Hotel::where('owner_id', Auth::id())->get();
        $facilities = Facility::all();
        return view('owner.branches.edit', compact('branch', 'hotels', 'facilities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'is_main' => 'required|boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $branch = Branch::findOrFail($id);
        $branch->update([
            'hotel_id' => $request->hotel_id,
            'name' => $request->name,
            'address' => $request->address,
            'is_main' => $request->is_main,
        ]);

        if ($request->has('facilities')) {
            $branch->facilities()->sync($request->facilities);
        }

        return redirect()->route('owner.branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return redirect()->route('owner.branches.index')->with('success', 'Branch deleted successfully.');
    }
}
