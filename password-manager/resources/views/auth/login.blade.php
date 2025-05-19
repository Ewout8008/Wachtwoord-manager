<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
</head>
<body>
    <h1>Inloggen met hoofdwachtwoord</h1>

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <input type="password" name="password" placeholder="Hoofdwachtwoord" required autofocus>
        <button type="submit">Login</button>
    </form>

    @error('password')
        <p style="color: red;">{{ $message }}</p>
    @enderror

</body>
</html>
