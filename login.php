<?php


session_start();
require_once 'config/database.php';

// Debug koneksi database
try {
    $db->query("SELECT 1");
    // echo "Database connected successfully";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// if (isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = 'Username tidak ditemukan';
        } else if (!password_verify($password, $user['password'])) {
            $error = 'Password salah';
        } else if ($user['status'] !== 'active') {
            $error = 'Akun tidak aktif';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Update last login
            $update = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $update->execute(['id' => $user['id']]);
            if ($user['role'] == 'admin') {
                header('Location: admin/index.php');
            } else {
                // Redirect ke my_courses.php untuk user biasa
                header('Location:profile.php');
            }
            exit();
        }
    } catch(PDOException $e) {
        $error = 'Terjadi kesalahan sistem';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CyberOnly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #10B981;
            --dark-bg: #1F2937;
            --dark-card: #2D3748;
            --light-text: #F3F4F6;
            --dark-text: #1F2937;
        }

        body {
            background: linear-gradient(135deg, #4F46E5 0%, #10B981 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .auth-header {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0.9;
            z-index: 1;
        }

        .auth-header * {
            position: relative;
            z-index: 2;
        }

        .auth-header i {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 15px;
        }

        .auth-header h3 {
            color: white;
            font-weight: 600;
            font-size: 1.8rem;
            margin: 0;
        }

        .auth-body {
            padding: 40px 30px;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-control {
            border: 2px solid rgba(79, 70, 229, 0.1);
            border-radius: 12px;
            padding: 12px 20px;
            height: auto;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .form-floating label {
            padding: 12px 20px;
            color: #666;
        }

        .btn-auth {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* Dark Mode */
        .dark-mode body {
            background: linear-gradient(135deg, var(--dark-bg), var(--dark-card));
        }

        .dark-mode .auth-card {
            background: rgba(45, 55, 72, 0.9);
        }

        .dark-mode .form-control {
            background: rgba(45, 55, 72, 0.9);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--light-text);
        }

        .dark-mode .form-control:focus {
            background: var(--dark-card);
            border-color: var(--primary-color);
        }

        .dark-mode .form-floating label {
            color: #CBD5E0;
        }

        .dark-mode .auth-footer {
            color: #CBD5E0;
        }

        .dark-mode .auth-footer a {
            color: var(--secondary-color);
        }

        .dark-mode .password-toggle {
            color: #CBD5E0;
        }

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="fas fa-shield-alt"></i>
                <h3 class="mb-0">Login CyberOnly</h3>
            </div>
            <div class="auth-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Username" required>
                        <label for="username">Username</label>
                    </div>
                    
                    <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">Password</label>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                    
                    <div class="text-center mt-3">
                        Belum punya akun? <a href="register.php" class="text-primary">Register disini</a>
                    </div>
                    
                    <button type="submit" class="btn btn-auth">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html> 