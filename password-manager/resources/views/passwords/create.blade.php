<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuw wachtwoord toevoegen</title>
</head>
<body>
    <h1>Nieuw wachtwoord toevoegen</h1>
    <form method="POST" action="{{ url('/passwords') }}">
        @csrf
        <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
        <input type="url" name="url" placeholder="URL" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <input type="text" name="note" placeholder="Opmerking (optioneel)"><br>
        <input type="text" name="category" placeholder="Categorie" required><br>
        <input type="number" name="refresh_weeks" placeholder="Verversingsfrequentie (weken)"><br>
        <button type="submit">Opslaan</button>
    </form>

    <a href="/dashboard">Terug naar dashboard</a>
</body>
</html>
