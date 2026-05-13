<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP — Entrar</title>
    @vite('resources/css/components/login.css')
</head>
<body>
    <div class="auth-shell">
        <main class="auth-card" aria-labelledby="auth-title">
            <header class="auth-brand">
                <img src="{{ asset('images/logo_azul.png') }}" alt="ERP" class="auth-logo" width="160" height="48">
                <p class="auth-eyebrow">Plataforma</p>
                <h1 id="auth-title" class="auth-title">Acesso ao sistema</h1>
            </header>

            @if (session('status'))
                <div class="auth-flash auth-flash--success" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-flash auth-flash--danger" role="alert">
                    <ul class="auth-flash-list">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pagina.login.post') }}" class="auth-form">
                @csrf
                <div class="auth-field">
                    <label class="auth-label" for="email">E-mail</label>
                    <input
                        class="auth-input"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="auth-field-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth-field">
                    <label class="auth-label" for="password">Senha</label>
                    <input
                        class="auth-input"
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <p class="auth-field-error">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="auth-submit">Entrar</button>
            </form>
        </main>
    </div>
</body>
</html>
