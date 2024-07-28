<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserRejected;
use App\Mail\UserApproved;


use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function manageApprovals()
    {
        $users = User::where('is_approved', false)
            ->where('request_send', true)
            ->where('role', 'hotel_owner')
            ->get();

        return view('admin.manage-approvals', compact('users'));
    }
    public function approveUser(User $user)
    {
        $user->is_approved = true;
        if($user->request_send==false){
            $user->request_send=true;
        }
        $user->save();

        Mail::to($user->email)->send(new UserApproved($user));
        // event(new UserApproved($user));

        return redirect()->back()->with('success', 'User approved successfully.');
    }
    public function disapproveUser(User $user)
    {
        $user->is_approved = false;
        $user->request_send = false;
        $user->save();

        return redirect()->back()->with('success', 'User dis-approved successfully.');
    }

    public function rejectUser(User $user)
    {
        Mail::to($user->email)->send(new UserRejected($user));
        $user->delete();
        return redirect()->back()->with('success', 'User rejected successfully.');
    }
    public function viewUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    // Method to view a specific user by ID for Approval
    public function viewUser($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.user-view', compact('user')); // Ensure this view exists
    }
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
