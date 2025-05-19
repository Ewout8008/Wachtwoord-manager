@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Wachtwoorden per categorie</h2>

    @foreach($passwords as $category => $items)
        <div class="card">
            <h3>{{ $category }}</h3>
            <ul>
                @foreach($items as $password)
                    <li style="margin-bottom: 1rem;">
                        <strong>URL:</strong> {{ $password->url }} <br>
                        <strong>Gebruikersnaam:</strong> {{ $password->username }} <br>
                        <strong>Opmerking:</strong> {{ $password->note ?? '-' }} <br>
                        <strong>Verversingsfrequentie:</strong> {{ $password->refresh_weeks ?? '-' }} weken <br>
                        <strong>Wachtwoord:</strong> ********

                        <form method="POST" action="/passwords/{{ $password->id }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="margin-left: 10px;">Verwijder</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection
