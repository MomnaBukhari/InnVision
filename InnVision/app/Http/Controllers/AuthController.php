<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OTP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('authentication.register');
    }
    public function showLoginForm()
    {
        return view('authentication.login');
    }
    public function showOtpForm()
    {
        return view('authentication.verify-otp');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,hotel_owner,customer',
        ]);

        $defaultProfilePicture = '/images/default_profile_picture.jpg';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_picture' => $defaultProfilePicture,
        ]);

        $otp = $this->generateOtp();
        OTP::create(['user_id' => $user->id, 'otp' => $otp]);
        Mail::to($user->email)->send(new OTPMail($otp));

        return redirect()->route('verify-otp')->with('user_id', $user->id);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $otp = $this->generateOtp();
            OTP::create(['user_id' => $user->id, 'otp' => $otp]);
            Mail::to($user->email)->send(new OTPMail($otp));
            return redirect()->route('verify-otp')->with('user_id', $user->id);
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $otpRecord = OTP::where('user_id', $request->user_id)->latest()->first();

        if ($otpRecord && $otpRecord->otp == $request->otp) {
            $user = User::find($request->user_id);
            auth()->login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'hotel_owner') {
                return redirect()->route('owner.dashboard');
            } elseif ($user->role === 'customer') {
                return redirect()->route('customer.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('home');
    }

    private function generateOtp()
    {
        return rand(100000, 999999);
    }
}
