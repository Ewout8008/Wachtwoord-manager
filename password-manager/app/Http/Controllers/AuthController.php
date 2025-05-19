<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPassword;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);
        $inputPassword = $request->password;

        $master = MasterPassword::first();

        if (!$master) {
            // Eerste keer: stel hoofdwachtwoord in
            MasterPassword::create([
                'password_hash' => Hash::make($inputPassword),
            ]);
            session(['auth' => true, 'key' => $inputPassword]);
            return redirect('/dashboard');
        }

        if (Hash::check($inputPassword, $master->password_hash)) {
            session(['auth' => true, 'key' => $inputPassword]);
            return redirect('/dashboard');
        }

        return back()->withErrors(['password' => 'Ongeldig hoofdwachtwoord']);
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
