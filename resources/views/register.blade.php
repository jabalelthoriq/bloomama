<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomama - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body, html {
        height: 100%;
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f0f4f8;
    }
    .register-container {
        display: flex;
        height: 100vh;
        width: 100vw;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0;
    }
    .register-wrapper {
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
        height: 80%;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 40px;
        margin-top: 60px;
        margin-right: 200px;
        border-radius: 20px;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
    }
    .register-form {
        width: 90%;
    }
    .register-form h2 {
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
    .btn-register {
        background-color: #1dbfc1;
        border: none;
        padding: 12px;
        color: white;
        font-weight: bold;
        width: 100%;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .btn-register:hover {
        background-color: #19a6a9;
    }
    .login-text {
        text-align: center;
        margin-top: 20px;
    }
    .login-link {
        color: #1dbfc1;
        text-decoration: none;
        font-weight: bold;
    }
    .alert {
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .register-wrapper {
            flex-direction: column;
        }
        .illustration-side, .form-side {
            width: 100%;
        }
    }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-wrapper">
            <div class="illustration-side">
                <h1>Register to</h1>
                <h1>Bloomama</h1>
                <p>Create your account to join our community<br>and access all our features!</p>
                <img src="{{ asset('image/Saly-14.png') }}" alt="Bloomama Illustration">
            </div>
            <div class="form-side">
                <div class="register-form">
                    <h2>Create Account</h2>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required />

                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required />

                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" required />

                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />

                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required />

                        <button type="submit" class="btn-register">Register</button>

                        <div class="login-text">
                            <p>Already have an account?
                                <a href="{{ route('login') }}" class="login-link">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
