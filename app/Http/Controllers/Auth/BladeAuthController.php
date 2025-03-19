<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\WebsiteMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class BladeAuthController extends Controller
{
    public function index()
    {
        return view('Auth.register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password|min:5'
        ]);
        $password=Hash::make($request->password);
        $token = hash('sha256', time());
        $obj = new User();
        $obj->user_name = $request->user_name;
        $obj->email = $request->email;
        $obj->password = $password;
        $obj->access_token = null;
        $obj->token = $token;
        $obj->status = 0;
        $obj->save();
        $verification_link=url('register/verify/'.$request->email.'/'.$token);
        $subject = 'Sign Up Verification';
        $message = 'Please click on the link below to confirm Sign Up:<br>';
        $message .= '<a href="' . $verification_link . '">';
        $message .= $verification_link;
        $message .= '</a>';
        Mail::to($request->email)->send(new WebsiteMail($subject, $message));
        return redirect()->route('login')->with('success','Your Account Has Been Created Successfully');
    }
    public function login()
    {
        return view('Auth.login');
    }
    public function login_submit(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required|min:5'
        ]);
        $credential = [
            'user_name' => $request->user_name,
            'password' => $request->password,
        ];
        if (Auth::guard('user')->attempt($credential)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with('error', 'Your Data Not Correct');
        }
    }
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('login');
    }
    public function forget_password()
    {
        return view('Auth.forget_password');
    }
    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $data = User::where('email', $request->email)->first();
        if (!$data) {
            return redirect()->back()->with('error', 'Email Not Found');
        }
        $token = hash('sha256', time());
        $data->token = $token;
        $data->update();
        $reset_link = url('reset-password/' . $token . '/' . $request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="' . $reset_link . '">Click Here</a>';
        Mail::to($request->email)->send(new WebsiteMail($subject, $message));
        return redirect()->route('login')->with('success', 'Reset Link Sent to Your Email');
    }
    public function reset_password($token, $email)
    {
        $data = User::where('token', $token)->where('email', $email)->first();
        if (!$data) {
            return redirect()->route('login');
        }
        return view('Auth.reset_password', compact('token', 'email'));
    }
    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        $data = User::where('token', $request->token)->where('email', $request->email)->first();
        $data->password = Hash::make($request->password);
        $data->token = '';
        $data->update();
        return redirect()->route('login')->with('success', 'Password Changed Successfully');
    }
    public function verify($email,$token)
    {
        $user_data = User::where('email', $email)->where('token', $token)->first();
        if ($user_data) {
            $user_data->token = '';
            $user_data->status = 1;
            $user_data->update();
            return redirect()->route('login')->with('success', 'Your Account is verified successfully!');
        } else {
            return redirect()->route('home');
        }
    }
}
