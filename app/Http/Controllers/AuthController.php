<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'user_email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // $getAdmin = Admin::where('username', $request->user_email)->orWhere('email', $request->user_email)->first();

        // if (!$getAdmin) return redirect()->back()->with('error', 'Username or Password is Wrong!');
        // if (!Hash::check($request->password, $getAdmin->password)) return redirect()->back()->with('error', 'Username or Password is Wrong!');

        // unset($getAdmin->password);

        // $data = [
        //     'id' => $getAdmin->id,
        //     'username' => $getAdmin->username,
        //     'name' => $getAdmin->name,
        //     'email' => $getAdmin
        // ];

        // if (Auth::login($getAdmin)) return redirect('/admin/dashboard');

        if (!Auth::attempt([
            fn (Builder $query) => $query->where('username', $request->user_email)->orWhere('email', $request->user_email),
            'password' => $request->password,
        ]))
            return redirect()->back()->with('error', 'Username or Password is Wrong!');

        return redirect('/admin/dashboard');
    }

    public function logout(Request $request)
    {

        if ($request->id !== Auth::user()->id) return abort(401);
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
