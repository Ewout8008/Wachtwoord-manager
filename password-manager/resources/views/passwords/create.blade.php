@extends('layouts.app')

@section('title', 'Nieuw wachtwoord toevoegen')

@section('content')
    <h1>Nieuw wachtwoord toevoegen</h1>

    <form method="POST" action="{{ url('/passwords') }}" style="max-width: 400px;">
        @csrf

        <label>Gebruikersnaam</label><br>
        <input type="text" name="username" class="form-control" required><br>

        <label>URL</label><br>
        <input type="url" name="url" class="form-control" required><br>

        <label>Wachtwoord</label><br>
        <input type="password" name="password" class="form-control" required><br>

        <label>Opmerking (optioneel)</label><br>
        <input type="text" name="note" class="form-control"><br>

        <label>Categorie</label><br>
        <input type="text" name="category" class="form-control" required><br>

        <label>Verversingsfrequentie (in weken)</label><br>
        <input type="number" name="refresh_weeks" class="form-control"><br>

        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Opslaan</button>

    </form>

    @if($errors->any())
        <ul style="color:red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection
