<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Informasi SKK</title>
    <!-- Favicon Logo Lab -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/images/GambarLogo.jpg') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font -->
    <link href="<?= base_url('assets/vendor/inter/index.css') ?>" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: #f4f7fa;
            color: #111827;
        }

        /* ===== LAYOUT ===== */
        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ===== LEFT ===== */
        .auth-left {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #002366;
            color: white;
        }

        .login-box {
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .login-box h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .login-box h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 6px 0 14px;
        }

        .login-box p {
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 28px;
        }

        /* ===== ALERT ERROR ===== */
        .alert-error {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(239, 68, 68, 0.45);
            color: #fff;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.35s;
        }

        .alert-error i {
            font-size: 16px;
            color: #fecaca;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            50% { transform: translateX(4px); }
            75% { transform: translateX(-4px); }
            100% { transform: translateX(0); }
        }

        /* ===== INPUT ===== */
        .input-field {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0 18px;
            height: 56px;
            margin-bottom: 14px;
        }

        .input-field i {
            margin-right: 14px;
            font-size: 16px;
        }

        .input-field input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            color: white;
        }

        .input-field input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        /* ===== BUTTON ===== */
        .btn-login {
            width: 100%;
            height: 48px;
            margin-top: 10px;
            border-radius: 10px;
            border: 2px solid #fff;
            background: transparent;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #fff;
            color: #002366;
        }

        /* ===== BACK LINK ===== */
        .back-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #fff;
        }

        /* ===== RIGHT ===== */
        .auth-right {
            background: white;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-logo {
            max-width: 100%;
            height: auto;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
            }

            .auth-right {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <!-- LEFT -->
    <div class="auth-left">
        <div class="login-box">

            <h2>Laboratorium Smart System</h2>
            <h3>Informatika</h3>

            <!-- ALERT ERROR -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-error">
                    <i class="fas fa-circle-exclamation"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/api/auth/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input
                        type="text"
                        name="nomor"
                        placeholder="NIM / Username"
                        value="<?= old('nomor') ?>"
                        required>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        required>
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>

            </form>

            <!-- BACK TO HOME LINK -->
            <div style="margin-top: 20px;">
                <a href="/" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Homepage
                </a>
            </div>

        </div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <img src="<?= base_url('assets/images/GambarLogo.jpg') ?>"
             alt="Logo Lab SSIP"
             class="main-logo">
    </div>

</div>

</body>
</html>
