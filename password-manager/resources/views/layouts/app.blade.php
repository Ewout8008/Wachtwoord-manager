<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Wachtwoord Manager')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background-color: #f7f9fc;
            color: #333;
        }
        header, footer {
            margin-bottom: 2rem;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .card {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-bottom: 1rem;
        }
        a.button, button {
            background: #3498db;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        a.button:hover, button:hover {
            background: #2980b9;
        }
        .top-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        ul {
            padding-left: 1rem;
        }
        main {
            min-height: 60vh;
        }
    </style>
</head>
<body>
    <header>
        <h1>Wachtwoord Manager</h1>
        <div class="top-links">
            <div>
                <a href="/dashboard" class="button">Dashboard</a>
                <a href="/passwords/create" class="button">Nieuw wachtwoord</a>
                <a href="/settings" class="button">Hoofdwachtwoord wijzigen</a>
                

            </div>
            <div>
                <a href="/logout" class="button">Uitloggen</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Jouw Naam</p>
    </footer>
</body>
</html>
