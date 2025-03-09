<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - المنصة التعليمية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("{{ asset('assets/imgs/background.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
        }
        .auth-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 35%;
            height: auto;
        }
        .auth-container h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        .btn-custom {
            width: 100%;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>مرحبًا بك في المنصة </h2>
        <div class="text-center" style="flex-grow: 1; padding: 40px; background: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <h2 style="font-family: 'Roboto', sans-serif; color: #007bff; margin-bottom: 20px; font-size: 28px;">مرحبًا بك في المنصة!</h2>

            @if(session('success'))
                <div class="alert alert-success" style="font-size: 18px; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="font-size: 18px; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif

            @auth
                <p style="font-size: 18px; color: #555;">مرحبًا، لقد قمت بتسجيل الدخول بالفعل!</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger mt-3" style="width: 100%; font-size: 16px;">تسجيل الخروج</button>
                </form>
            @else
                <div class="d-flex flex-column align-items-center mt-4">
                    <button class="btn btn-primary mb-3" id="login-btn" style="width: 100%; padding: 10px; font-size: 16px;">تسجيل الدخول</button>
                    <button class="btn btn-success" id="register-btn" style="width: 100%; padding: 10px; font-size: 16px;">إنشاء حساب جديد</button>
                </div>

                <div id="login-form" class="mt-3" style="display: none;">
                    <h2 style="font-size: 22px; color: #007bff;">تسجيل الدخول</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="email" style="font-size: 16px; color: #333;">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required style="border-radius: 5px; font-size: 16px;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" style="font-size: 16px; color: #333;">كلمة المرور</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required style="border-radius: 5px; font-size: 16px;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-2" style="width: 100%; padding: 10px; font-size: 16px;">تسجيل الدخول</button>
                    </form>
                </div>

                <div id="register-form" class="mt-3" style="display: none;">
                    <h2 style="font-size: 22px; color: #28a745;">إنشاء حساب جديد</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" style="font-size: 16px; color: #333;">الاسم الكامل</label>
                            <input type="text" name="name" class="form-control" required style="border-radius: 5px; font-size: 16px;">
                        </div>
                        <div class="form-group">
                            <label for="email" style="font-size: 16px; color: #333;">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" required style="border-radius: 5px; font-size: 16px;">
                        </div>
                        <div class="form-group">
                            <label for="password" style="font-size: 16px; color: #333;">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required style="border-radius: 5px; font-size: 16px;">
                        </div>
                        <button type="submit" class="btn btn-success mt-2" style="width: 100%; padding: 10px; font-size: 16px;">إنشاء الحساب</button>
                    </form>
                </div>
            @endauth
        </div>

        <script>
            document.getElementById('login-btn').addEventListener('click', function() {
                let loginForm = document.getElementById('login-form');
                let registerForm = document.getElementById('register-form');
                loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
                registerForm.style.display = 'none';
            });

            document.getElementById('register-btn').addEventListener('click', function() {
                let registerForm = document.getElementById('register-form');
                let loginForm = document.getElementById('login-form');
                registerForm.style.display = registerForm.style.display === 'none' ? 'block' : 'none';
                loginForm.style.display = 'none';
            });
        </script>
</body>
</html>
