<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">

    <!-- Custom CSS -->
    <style>
        /* Center the logo and login box */
        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Stack logo and box vertically */
            height: 100vh;
            background-color: rgb(228, 228, 228); /* Background color */
        }

        .image {
            margin-bottom: 20px; /* Space between logo and login box */
        }

        .brand-link img {
            width: 300px; /* Set logo width */
            height: auto; /* Maintain aspect ratio */
        }

        .login-box {
            width: 400px; /* Adjust login box width */
        }

        .btn-block {
            width: 100%; /* Full width for buttons */
        }

        .login-card-body {
            padding: 30px; /* Padding for better spacing */
        }

        /* Form input adjustments */
        .form-control {
            font-size: 16px;
        }

        /* Error message styling */
        .error-message {
            color: rgb(255, 0, 0); /* Set error message color to red */
            font-size: 14px; /* Optional: Adjust font size */
            margin-top: 5px; /* Space before error message */
        }

        /* Spacing between password and remember me */
        .input-group + .icheck-primary {
            margin-top: 15px;
        }

        /* Additional space between Remember Me and Sign In */
        .icheck-primary + .row {
            margin-top: 15px;
        }

        /* Add margin below Sign In button */
        .btn-block {
            margin-bottom: 20px; /* Added margin to create space between Sign In and Forgot Password */
        }

        /* Additional space between Sign In button and Forgot Password */
        .row + p.mb-1 {
            margin-top: 20px;
        }

        /* Custom color for Sign In button */
        .btn-primary {
            background-color: rgb(16, 16, 16); /* Custom color for button */
            border-color: rgb(10, 10, 10); /* Border for the button */
        }

        /* Remove hover effect (no color change on hover) */
        .btn-primary:hover {
            background-color: rgb(16, 16, 16); /* Same color on hover */
            border-color: rgb(10, 10, 10); /* Same border color */
        }

        /* Outline of card turned black */
        .card-outline.card-primary {
            border-top: 3px solid rgb(0, 0, 0); /* Black outline */
        }

        /* Change Forgot Password link color to black */
        .mb-1 a {
            color: rgb(0, 0, 0); /* Set to black */
        }
    </style>
</head>

<body class="hold-transition login-page">

    <!-- Logo placed outside the login box -->
    <div class="image">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logoSIG.png') }}" alt="SIG Logo" class="brand-image">
        </a>
    </div>

    <div class="login-box">
        <div class="card card-outline card-primary">
            <!-- Login Card -->
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <!-- Email Input -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                
                    <!-- Password Input -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                
                    <!-- Remember Me Checkbox -->
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                
                    <!-- Sign In Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <!-- Forgot Password Link -->
                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
