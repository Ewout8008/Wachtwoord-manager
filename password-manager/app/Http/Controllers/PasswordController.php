<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class PasswordController extends Controller

{


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



    public function update(Request $request, $id)
{
    $request->validate([
        'url' => 'required|string',
        'username' => 'required|string',
        'password' => 'required|string',
        'note' => 'nullable|string',
        'category' => 'required|string',
        'refresh_weeks' => 'nullable|integer',
    ]);

    $key = session('key');
    if (!$key) {
        return redirect('/login')->withErrors('Sessie verlopen, log opnieuw in.');
    }

    $password = Password::findOrFail($id); 

    $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($request->password, 'aes-256-cbc', $key, 0, $iv);

    $password->update([
        'url' => $request->url,
        'username' => $request->username,
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

}

public function dashboard()
{
    $key = session('key');

    $passwords = Password::all()->groupBy('category')->map(function ($items) use ($key) {
        return $items->map(function ($password) use ($key) {
            $decrypted = openssl_decrypt(
                $password->encrypted_password,
                'aes-256-cbc',
                $key,
                0,
                base64_decode($password->iv)
            );
            $password->decrypted_password = $decrypted;
            return $password;
        });
    });

    return view('dashboard', compact('passwords'));
}




}
