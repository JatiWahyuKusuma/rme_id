<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: #ffffff;
            flex-direction: row-reverse;
        }

        /* Right side with background image - takes 60% width */
        .login-right {
            width: 50%;
            background-image: url("{{ asset('images/doser.jpg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Logo in top left corner */
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logo img {
            height: 90px;
        }

        /* Left side with login form - takes 40% width */
        .login-left {
            width: 50%;
            min-width: 420px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 150px;
            background-color: white;
        }

        /* Login header */
        .login-header {
            margin-bottom: 30px;
            text-align: center; /* Memposisikan teks di tengah */
        }

        .login-header h1 {
            font-size: 50px; /* Ukuran font diperbesar */
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .login-header h1 span:first-child {
            color: #800000; /* Warna merah untuk "LOGIN" */
        }

        .login-header h1 span:last-child {
            color: #000000; /* Warna hitam untuk "PAGE" */
        }

        /* Form styling */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #800000;
            font-size: 19px;
            font-weight: 650;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 3px solid #2e2e2e;
            border-radius: 6px;
            font-size: 14px;
            color: #333333;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #000000;
        }

        .input-group-text {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #777777;
            font-size: 14px;
        }

        /* Remember me checkbox */
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            accent-color: #800000;
        }

        .remember-me label {
            font-size: 17px;
            color: #000000;
            font-weight: 500;
        }

        /* Sign In button */
        .btn-signin {
            width: 100%;
            padding: 12px;
            background-color: #800000;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
            margin-bottom: 25px;
            transition: background-color 0.3s;
        }

        .btn-signin:hover {
            background-color: #d00000;
        }

        /* Forgot password link */
        .forgot-password {
            text-align: center;
        }

        .forgot-password a {
            color: #000000;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #555555;
        }

        /* Error message styling */
        .error-message {
            color: #ff0000;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <!-- Right side with background image (60% width) -->
    <div class="login-right"></div>
    
    <!-- Logo in top left corner -->
    <div class="logo">
        <img src="{{ asset('images/logoSIG.png') }}" alt="SIG Logo">
    </div>

    <!-- Left side with login form (40% width) -->
    <div class="login-left">
        <div class="login-header">
            <h1><span>LOGIN</span> <span>PAGE</span></h1>
        </div>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <!-- Email Input -->
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="btn-signin">Sign In</button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Login Berhasil",
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 1500,
            });
        @elseif (session('failed'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('failed') }}',
                timer: 3000,
                showConfirmButton: true
            });
        @endif
    </script>
</body>

</html>