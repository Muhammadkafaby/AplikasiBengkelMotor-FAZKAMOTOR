<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FAZKAMOTOR</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            opacity: 0.3;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            opacity: 0.3;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .brand-logo h1 span {
            color: #667eea;
        }

        .brand-logo p {
            color: #64748b;
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 1rem 1rem 1rem 3rem;
            height: 60px;
            font-size: 1rem;
        }

        .form-floating .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-floating label {
            padding-left: 3rem;
            color: #64748b;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 5;
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            z-index: 5;
        }

        .motorcycle-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <i class="fas fa-motorcycle motorcycle-icon floating"></i>
                <h1><span>FAZKA</span>MOTOR</h1>
                <p>Sistem Inventory & Kasir Bengkel Motor</p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-floating position-relative">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        value="<?= old('username') ?>" required autofocus>
                    <label for="username">Username</label>
                </div>

                <div class="form-floating position-relative mb-4">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                    <span class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">
                    ©
                    <?= date('Y') ?> FAZKAMOTOR. All rights reserved.
                </small>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>