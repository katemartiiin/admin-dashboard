<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    function login(Request $request){
      $username = User::where('username', $request->get('useremail'))->first();
      $email = User::where('email', $request->get('useremail'))->first();
      // Login with username
      if ($username) {
        $this->validate($request, [
          'useremail' => 'required|min:3',
          'password' => 'required|alphaNum|min:3'
        ]);
        $user_data = array(
          'username' => $request->get('useremail'),
          'password' => $request->get('password')
        );
        if (Auth::attempt($user_data)){
          Auth::login($username, $request->get('remember'));
          return redirect('dashboard');
        } else {
          return back()->with('error', 'Incorrect username or password');
        }
      }
      // Login with email
      if ($email) {
        $this->validate($request, [
          'useremail' => 'required|email',
          'password' => 'required|alphaNum|min:3'
        ]);
    
        $user_data = array(
          'email' => $request->get('useremail'),
          'password' => $request->get('password')
        );

        if (Auth::attempt($user_data)){
          Auth::login($email, $request->get('remember'));
          return redirect('dashboard');
        } else {
          return back()->with('error', 'Incorrect email or password');
        }
      } 
    }
  
    function logout(){
        Auth::logout();
        return redirect('/');
    }
}