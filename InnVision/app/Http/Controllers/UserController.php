<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function ViewCustomerDashboard()
    {
        return view('customer.dashboard');
    }
    public function ViewOwnerDashboard()
    {
        return view('owner.dashboard');
    }

    public function ViewAdminDashboard()
    {
        return view('admin.dashboard');
    }

    public function showProfile()
    {
        $user = auth()->user();
        switch ($user->role) {
            case 'hotel_owner':
                return view('owner.profile', compact('user'));
            case 'admin':
                return view('admin.profile', compact('user'));
            case 'customer':
            default:
                return view('customer.profile', compact('user'));
        }
    }
    public function editProfile()
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'hotel_owner':
                return view('owner.edit-profile', ['user' => $user]);
            case 'admin':
                return view('admin.edit-profile', ['user' => $user]);
            case 'customer':
            default:
                return view('customer.edit-profile', ['user' => $user]);
        }
    }

    public function updateProfile(Request $request)
{
    \Log::info('Request Data:', $request->all());

    $user = auth()->user();

    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'contact_number' => 'nullable|string',
        'address' => 'nullable|string|max:255',
        'about' => 'nullable|string',
    ];

    $request->validate($rules);

    \Log::info('Validated Data:', $request->all());

    // Proceed with the update logic
    $user->name = $request->name;
    $user->email = $request->email;
    $user->contact_number = $request->contact_number;
    $user->address = $request->address;
    $user->about = $request->about;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('profile_picture')) {
        $profilePicture = $request->file('profile_picture');
        $profilePictureName = time() . '.' . $profilePicture->getClientOriginalExtension();
        $profilePicture->move(public_path('images'), $profilePictureName);
        $user->profile_picture = '/images/' . $profilePictureName;
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}
    public function deleteProfile()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Admin accounts cannot be deleted.');
        }
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
