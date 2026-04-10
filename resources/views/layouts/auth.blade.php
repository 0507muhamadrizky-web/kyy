<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            /* display: flex;
            justify-content: center;
            align-items: center; */
            overflow-x: hidden;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
            padding: 2rem;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0px 10px 30px rgba(0,0,0,0.2);
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: #fff;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 14px;
            transition: 0.2s;
            pointer-events: none;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -6px;
            left: 10px;
            font-size: 12px;
            color: #2575fc;
            background: white;
            padding: 0 4px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #6a11cb;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
        }


        /* Force text colors to be white within the login container */
        .login-container h2,
        .login-container label,
        .login-container span,
        .login-container .text-gray-700,
        .login-container .text-gray-600 {
            color: #fff !important;
        }

        /* Ensure links are visible */
        .login-container a {
            color: #e0e0e0 !important;
        }
        
        .login-container a:hover {
            color: #fff !important;
            text-decoration: underline;
        }

        /* Ensure input fields have readable dark text on white background */
        .login-container input {
            color: #1f2937 !important; /* gray-800 */
            background-color: #fff !important;
        }

    </style>
</head>
<body>

    <!-- Video Background (same as welcome) -->
    <video autoplay loop muted playsinline class="fixed top-0 left-0 w-full h-full object-cover" style="min-height:100vh; min-width:100vw; z-index:0;">
        <source src="{{ asset('storage/banner.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0, 0, 0, 0);z-index:1;pointer-events:none;"></div>

    <div style="position:relative; z-index:10; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 1rem;">
        <div class="login-container">
            @yield('content')
        </div>
    </div>

    <!-- Bubbles removed for auth layout -->



    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            }
        }
    </script>
</body>
</html>
