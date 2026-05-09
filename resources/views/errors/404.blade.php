<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Página não encontrada</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #2c5aa0;
            --surface: #ffffff;
            --line: #cfd8e3;
            --text: #1f2a37;
            --muted: #5f6c79;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
            color: var(--text);
            background:
                radial-gradient(circle at 14% 16%, rgba(255, 255, 255, 0.22) 0%, transparent 42%),
                linear-gradient(135deg, #1e3a5f 0%, #2c5aa0 100%);
        }

        .error-container {
            width: min(430px, 100%);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 40px 26px;
            box-shadow: 0 18px 36px rgba(44, 90, 160, 0.22);
            text-align: center;
        }

        .error-code {
            font-size: 80px;
            font-weight: 700;
            color: var(--accent);
            margin: 0;
            line-height: 1;
        }

        .error-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
            margin: 12px 0 8px;
        }

        .error-message {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 28px;
        }

        .btn-voltar {
            display: inline-block;
            background: linear-gradient(135deg, #1e3a5f, #2c5aa0);
            color: #fff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        .btn-voltar:hover {
            opacity: 0.88;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <p class="error-code">404</p>
        <p class="error-title">Página não encontrada</p>
        <p class="error-message">A página que você está procurando não existe ou foi removida.</p>
        <a href="{{ url('/') }}" class="btn-voltar">Voltar ao início</a>
    </div>
</body>
</html>