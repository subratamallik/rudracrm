<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $response = [];
        return view('login', ['response' => $response]);
    }


    public function loginPost(Request $request)
    {
        $formData = $request->input();
        $payload = [
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];
        $authResult = Auth::attempt($payload);
        if ($authResult) {
            return redirect('/');
        } else {
            return redirect()->back()->with('danger', 'Incorrect credentials, please try again!');
        }
    }

    public function logout(Request $request)
    {
        Session::forget('user_menus');
        Session::forget('user_roles');
        Session::forget('logged_user');
        Auth::logout();
        return redirect('/login')->with('success', 'Logged Out Successfully!');
    }
}
