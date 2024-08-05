<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class OwnerController extends Controller
{


    public function showPendingApproval() //method to display approval status page
    {
        $user = Auth::user();
        return view('owner.pending-approval', compact('user'));
    }


    public function requestApproval(Request $request) //method to request approval
    {
        $user = Auth::user();
        // dd(123);

        $request->validate([
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'about' => 'required|string',
            'description' => 'required|string',
            'hotel_stars' => 'required|integer|min:1|max:7',
            'service_class' => 'required|string|in:elite,middle,lower,general,other',
        ]);

        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->about = $request->about;
        $user->description = $request->description;
        $user->hotel_stars = $request->hotel_stars;
        $user->service_class = $request->service_class;
        $user->request_send = true;

        if ($user->save()) {
            return redirect()->route('owner.pending-approval')->with('success', 'Your approval request has been submitted. Please wait for approval.');
        } else {
            return redirect()->route('owner.pending-approval')->with('error', 'Failed to submit approval request. Please try again.');
        }
    }


    public function cancelRequest() //method to cancel sent request
    {
        $user = Auth::user();
        $user->request_send = false;

        if ($user->save()) {
            return redirect()->route('owner.pending-approval')->with('success', 'Your approval request has been canceled.');
        } else {
            return redirect()->route('owner.pending-approval')->with('error', 'Failed to cancel approval request. Please try again.');
        }
    }
}
