@extends('layouts.guest')

@section('title', 'Inloggen')

@section('content')
    <h2>Inloggen met hoofdwachtwoord</h2>

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <input type="password" name="password" placeholder="Hoofdwachtwoord" required autofocus>
        <button type="submit">Login</button>
    </form>

    @error('password')
        <p style="color: red;">{{ $message }}</p>
    @enderror
@endsection
