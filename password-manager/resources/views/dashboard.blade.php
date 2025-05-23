@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Wachtwoorden per categorie</h2>

    @foreach($passwords as $category => $items)
        <div class="card" style="margin-bottom: 2rem; padding: 1rem;">
            <h3>{{ $category }}</h3>
            <ul>
                @foreach($items as $password)
                    <li style="margin-bottom: 2rem;">
                        <div>
                            <strong>URL:</strong> {{ $password->url }} <br>
                            <strong>Gebruikersnaam:</strong> {{ $password->username }} <br>
                            <strong>Opmerking:</strong> {{ $password->note ?? '-' }} <br>
                            <strong>Verversingsfrequentie:</strong> {{ $password->refresh_weeks ?? '-' }} weken <br>
                            <strong>Categorie:</strong> {{ $password->category }} <br>

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

                            <button type="button" class="toggle-edit-form" style="margin-left: 10px;">Bewerk</button>
                        </div>

                        <form method="POST" action="/passwords/{{ $password->id }}" class="edit-form" style="display: none; margin-top: 1rem;">
                            @csrf
                            @method('PUT')

                            <label>URL:
                                <input type="text" name="url" value="{{ $password->url }}">
                            </label><br>

                            <label>Gebruikersnaam:
                                <input type="text" name="username" value="{{ $password->username }}">
                            </label><br>

                            <label>Opmerking:
                                <input type="text" name="note" value="{{ $password->note }}">
                            </label><br>

                            <label>Verversingsfrequentie (weken):
                                <input type="number" name="refresh_weeks" value="{{ $password->refresh_weeks }}">
                            </label><br>

                            <label>Categorie:
                                <input type="text" name="category" value="{{ $password->category }}">
                            </label><br>

                            <label>Wachtwoord:
                                <input type="text" name="password" value="{{ openssl_decrypt($password->encrypted_password, 'aes-256-cbc', session('key'), 0, base64_decode($password->iv)) }}">
                            </label><br>

                            <button type="submit">Opslaan</button>
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

        document.querySelectorAll('.toggle-edit-form').forEach(function(button) {
            button.addEventListener('click', function () {
                const form = this.closest('li').querySelector('.edit-form');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
@endsection
