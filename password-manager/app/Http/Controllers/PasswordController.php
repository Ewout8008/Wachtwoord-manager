<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class PasswordController extends Controller
{
    // Dashboard: lijst met wachtwoorden per categorie
    public function dashboard()
    {
        $passwords = Password::all()->groupBy('category');
        return view('dashboard', compact('passwords'));
    }

    // Formulier tonen om nieuw wachtwoord toe te voegen
    public function create()
    {
        return view('passwords.create');
    }

    // Nieuw wachtwoord opslaan
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

        $key = session('key'); // hoofdwachtwoord sleutel uit sessie
        if (!$key) {
            return redirect('/login')->withErrors('Sessie verlopen, log opnieuw in.');
        }

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

        return redirect('/dashboard')->with('success', 'Wachtwoord opgeslagen.');
    }



    // Wachtwoord updaten
    public function update(Request $request, Password $password)
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
        if (!$key) {
            return redirect('/login')->withErrors('Sessie verlopen, log opnieuw in.');
        }

        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($request->password, 'aes-256-cbc', $key, 0, $iv);

        $password->update([
            'username' => $request->username,
            'url' => $request->url,
            'note' => $request->note,
            'category' => $request->category,
            'refresh_weeks' => $request->refresh_weeks,
            'encrypted_password' => $encrypted,
            'iv' => base64_encode($iv),
        ]);

        return redirect('/dashboard')->with('success', 'Wachtwoord succesvol aangepast!');
    }

    // Wachtwoord verwijderen
    public function destroy(Password $password)
    {
        $password->delete();
        return back()->with('success', 'Wachtwoord verwijderd.');
    }

    public function edit(Password $password)
{
    $key = session('key');
    $decryptedPassword = openssl_decrypt(
        $password->encrypted_password,
        'aes-256-cbc',
        $key,
        0,
        base64_decode($password->iv)
    );

    return view('passwords.edit', compact('password', 'decryptedPassword'));
}

}
