<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Login</title>
    @vite('resources/css/components/login.css')
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <img src="{{ asset('images/logo_azul.png') }}" alt="ERP" class="login-logo">
            <h2>Acesso ao Sistema</h2>
        </div>

        @if (session('status'))
            <div class="login-error">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pagina.login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>