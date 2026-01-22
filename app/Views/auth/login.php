<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Informasi SKK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

        /* ===== LEFT (LOGIN) ===== */
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

        .logo {
            width: 64px;
            margin-bottom: 24px;
        }

        .login-box h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #ffffff;
        }

        .login-box h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 6px 0 14px;
            color: #ffffff;
        }

        .login-box p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 28px;
        }

        /* ===== INPUT ===== */
        .input-field {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0 18px;
            height: 56px;
            margin-bottom: 14px;
        }

        .input-field i {
            color: #ffffff;
            font-size: 16px;
            margin-right: 14px;
        }

        .input-field input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 14px;
            color: #ffffff;
        }

        .input-field input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* ===== BUTTON ===== */
        .btn-login {
            margin-top: 10px;
            width: 100%;
            height: 48px;
            border-radius: 10px;
            border: 2px solid #ffffff;
            background: transparent;
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #ffffff;
            color: #002366;
        }

        /* ===== RIGHT (BRANDING) ===== */
        .auth-right {
            background: #ffffff;
            padding: 60px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            text-align: center;
        }

        .main-logo {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }

        .branding-title {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            margin-top: 120px;
        }

        .branding-title span {
            color: white;
        }

        .branding-footer {
            position: absolute;
            bottom: 40px;
            left: 60px;
            right: 60px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 500;
            color: white;
        }

        /* ===== ILLUSTRATION GRID (SIMPLIFIED) ===== */
        .illustration-grid {
            position: absolute;
            top: 40px;
            right: 60px;
            display: grid;
            grid-template-columns: repeat(3, 80px);
            gap: 16px;
        }

        .illustration-box {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
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
            <h2>Laboratorium Smart System And Information Processing</h2>
            <h3>Informatika</h3>
            <form action="/api/auth/login" method="post">
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nomor" placeholder="NIM / Username" required>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

        </div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">

        <!-- Logo -->
        <div class="logo-container">
            <img src="<?php echo base_url('assets/images/GambarLogo.jpg'); ?>" alt="Logo Lab SSIP" class="main-logo">
        </div>

    </div>

</div>

</body>
</html>
