<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPassword;

class MasterPasswordController extends Controller
{
    public function edit()
    {
        return view('settings');
    }

    public function change(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $master = MasterPassword::first();

        if (!Hash::check($request->old_password, $master->password_hash)) {
            return back()->withErrors(['old_password' => 'Oude wachtwoord is onjuist.']);
        }

        $master->password_hash = Hash::make($request->new_password);
        $master->save();

        // Update sessie key
        session(['key' => $request->new_password]);

        return back()->with('status', 'Hoofdwachtwoord succesvol gewijzigd.');
    }
}
