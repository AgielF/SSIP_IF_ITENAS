<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - SSIP ITENAS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .error-container {
            text-align: center;
            max-width: 500px;
            padding: 2rem;
        }
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .error-message {
            font-size: 1.5rem;
            margin: 1rem 0;
        }
        .error-description {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 2rem;
        }
        .btn-home {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 12px 24px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">500</h1>
        <h2 class="error-message">Kesalahan Server Internal</h2>
        <p class="error-description">
            Terjadi kesalahan pada server. Tim teknis telah diberitahu dan sedang memperbaikinya.
        </p>
        <a href="/" class="btn-home">Kembali ke Beranda</a>
    </div>
</body>
</html>