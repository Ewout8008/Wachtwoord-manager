<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class PasswordController extends Controller
{
    public function dashboard()
    {
        $passwords = Password::all()->groupBy('category');
        return view('dashboard', compact('passwords'));
    }

    public function create()
    {
        return view('passwords.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'url' => 'required',
            'password' => 'required',
            'note' => 'nullable',
            'category' => 'required',
            'refresh_weeks' => 'nullable|integer',
        ]);

        $key = session('key');
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($request->password, 'aes-256-cbc', $key, 0, $iv);

        Password::create([
            'username' => $request->username,
            'url' => $request->url,
            'note' => $request->note,
            'category' => $request->category,
            'refresh_weeks' => $request->refresh_weeks,
            'encrypted_password' => $encrypted,
            'iv' => base64_encode($iv),
        ]);

        return redirect('/dashboard');
    }

    public function destroy(Password $password)
    {
        $password->delete();
        return back();
    }
    
}
