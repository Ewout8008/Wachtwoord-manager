@extends('layouts.app')

@section('title', 'Instellingen')

@section('content')
    <h2>Wijzig hoofdwachtwoord</h2>

    <form method="POST" action="{{ route('settings.update') }}">
        @csrf

        <label>Oud wachtwoord:</label><br>
        <input type="password" name="old_password" required><br><br>

        <label>Nieuw wachtwoord:</label><br>
        <input type="password" name="new_password" required><br><br>

        <button type="submit">Wachtwoord wijzigen</button>
    </form>

    @if(session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif
@endsection
