<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomama - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
        }
        .login-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
        }
        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100%;
            box-shadow: none;
            border-radius: 0;
        }
        .illustration-side {
            width: 55%;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 200px;
            padding-top: 100px;


        }
        .illustration-side h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .illustration-side p {
            color: #888;
            font-size: 1rem;

        }
        .illustration-side img {
            max-width: 400px;
            margin-bottom: 20px;
            margin-left: 300px;
            margin-right: 0px;


        }
        .form-side {
            width: 45%;
            height: 70%;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            margin-top: 100px;
            margin-right: 200px;
            border-radius: 20px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
        }
        .login-form {
            width: 90%;

        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-control {
            background-color: #f0f4f8;
            border: 2px solid #e0e6ed;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #1dbfc1;
            box-shadow: none;
            background-color: #f0f4f8;
        }
        .btn-login {
            background-color: #1dbfc1;
            border: none;
            padding: 12px;
            color: white;
            font-weight: bold;
            width: 100%;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #19a6a9;
        }
        .additional-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .forgot-password {
            color: #1dbfc1;
            text-decoration: none;
        }
        .signup-text {
            text-align: center;
            margin-top: 20px;
        }
        .create-account {
            color: #1dbfc1;
            text-decoration: none;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .illustration-side, .form-side {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="illustration-side">
                <h1>Sign In to</h1>
                <h1>Bloomama is simply</h1>
                <p>If you already have an account<br>You can Create account here!</p>
                <img src="{{ asset('image/Saly-14.png') }}" alt="Bloomama Illustration">
            </div>
            <div class="form-side">
                <div class="login-form">
                    <h2>Sign in</h2>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter email" value="{{ old('email') }}" required />
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" required />
                        <div class="additional-links">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" />
                                <label class="form-check-label" for="remember">Remember</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                        <div class="signup-text">
                            {{-- <p>Don't have an account?
                                <a href="register" class="create-account">Create account</a>
                            </p> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
