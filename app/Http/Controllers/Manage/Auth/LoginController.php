<?php

namespace App\Http\Controllers\Manage\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('manage.dashboard'));
        }
        return view('manage.authentications.login');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('manage.dashboard'));
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Admin::where('email','=',$request->email)
            ->where('status', 1)
            ->orderBy('id','DESC')
            ->first();

        if(!empty($user)) {
            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if(Auth::guard('admin')->attempt($credetials)){
                return redirect()->intended(route('manage.dashboard'))
                        ->withSuccess('You have Successfully loggedin');
            }
            else{
                return redirect(route('manage.login'))->withError('Invalid password.');
            }
        }
        else{
            return redirect(route('manage.login'))->withError('Account does not exist.');
        }
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::guard('admin')->logout();

        return Redirect(route('manage.login'));
    }
}
