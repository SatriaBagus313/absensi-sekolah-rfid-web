<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Al Magfiroh - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                font-family: 'Figtree', sans-serif;
            }
            .login-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
            }
            .login-container {
                background: white;
                border-radius: 16px;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                width: 100%;
                max-width: 420px;
                animation: slideUp 0.5s ease-out;
                margin: 0 auto;
            }
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .login-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 50px 30px;
                text-align: center;
                color: white;
                position: relative;
                overflow: hidden;
            }
            .login-header::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
            }
            .login-header h1 {
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 6px;
                position: relative;
                z-index: 1;
            }
            .login-header p {
                font-size: 14px;
                opacity: 0.95;
                position: relative;
                z-index: 1;
            }
            .login-content {
                padding: 40px 30px;
            }
            @media (max-width: 480px) {
                .login-wrapper {
                    padding: 12px;
                }
                .login-container {
                    border-radius: 14px;
                }
                .login-header {
                    padding: 36px 24px;
                }
                .login-header h1 {
                    font-size: 26px;
                }
                .login-header p {
                    font-size: 13px;
                }
                .login-content {
                    padding: 28px 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-wrapper">
            <div class="login-container">
                <div class="login-header">
                    <h1>Al Magfiroh</h1>
                    <p>Sistem Presensi RFID</p>
                </div>
                <div class="login-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
