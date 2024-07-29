<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserRejected;
use App\Mail\UserApproved;
use App\Models\User;



use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{



    public function manageApprovals() //this method will display Approval Requests to Admin
    {
        $users = User::where('is_approved', false)
            ->where('request_send', true)
            ->where('role', 'hotel_owner')
            ->get();
        return view('admin.manage-approvals', compact('users'));
    }




    public function approveUser(User $user) //this method will Help Admin to Approve Owners
    {
        $user->is_approved = true;
        if($user->request_send==false){
            $user->request_send=true;
        }
        $user->save();
        Mail::to($user->email)->send(new UserApproved($user));
        return redirect()->back()->with('success', 'User approved successfully.');
    }




    public function disapproveUser(User $user) //this method will Help Admin to Disapprove Owners
    {
        $user->is_approved = false;
        $user->request_send = false;
        $user->save();
        return redirect()->back()->with('success', 'User dis-approved successfully.');
    }




    public function rejectUser(User $user) //this method will Help Admin to Reject Owners & ultimately Delete their account
    {
        Mail::to($user->email)->send(new UserRejected($user));
        $user->delete();
        return redirect()->back()->with('success', 'User rejected successfully.');
    }




    public function viewUsers() //this method will Help Admin to View All Users
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }




    public function viewUser($userId) //this method will Help Admin to View any User
    {
        $user = User::findOrFail($userId);
        return view('admin.user-view', compact('user'));
    }




    public function deleteUser(User $user) //this method will Help Admin to Delete any User
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }



    // I will add new classes here if needed.


}
