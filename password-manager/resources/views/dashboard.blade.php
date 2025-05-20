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
                        
                        <strong>Wachtwoord:</strong>
                        <span class="hidden-password" data-password="{{ openssl_decrypt($password->encrypted_password, 'aes-256-cbc', session('key'), 0, base64_decode($password->iv)) }}">
                            ********
                        </span>

                        <button type="button" class="toggle-password">Toon</button>

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

    {{-- Scripts --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function () {
                const span = this.previousElementSibling;
                const isHidden = span.innerText === '********';
                span.innerText = isHidden ? span.dataset.password : '********';
                this.innerText = isHidden ? 'Verberg' : 'Toon';
            });
        });

        document.querySelectorAll('.hidden-password').forEach(function(span) {
            span.addEventListener('dblclick', function () {
                navigator.clipboard.writeText(span.dataset.password);
                alert('Wachtwoord gekopieerd naar klembord!');
            });
        });
    </script>
@endsection
