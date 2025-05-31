<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $whatsapp = htmlspecialchars(trim($_POST['whatsapp']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    try {
        // Validasi input
        if (empty($username) || empty($password) || empty($whatsapp) || empty($email)) {
            $error = 'Semua field harus diisi';
        } 
        // Validasi password match
        else if ($password !== $confirm_password) {
            $error = 'Password tidak cocok';
        }
        // Validasi panjang password
        else if (strlen($password) < 6) {
            $error = 'Password minimal 6 karakter';
        }
        // Validasi format nomor WhatsApp
        else if (!preg_match("/^[0-9]{10,13}$/", $whatsapp)) {
            $error = 'Format nomor WhatsApp tidak valid';
        }
        // Validasi email
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Format email tidak valid';
        } else {
            // Cek username sudah ada atau belum
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $error = 'Username sudah digunakan';
            } else {
                // Cek email sudah ada atau belum
                $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->rowCount() > 0) {
                    $error = 'Email sudah terdaftar';
                } else {
                    // Insert user baru
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $sql = "INSERT INTO users (username, password, email, whatsapp, role, status) 
                            VALUES (:username, :password, :email, :whatsapp, 'user', 'active')";
                    
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute([
                        ':username' => $username,
                        ':password' => $hashed_password,
                        ':email' => $email,
                        ':whatsapp' => $whatsapp
                    ]);

                    if ($result) {
                        $success = 'Registrasi berhasil! Silahkan login.';
                        // Tambahkan log untuk debugging
                        error_log("User baru terdaftar: $username");
                    } else {
                        $error = 'Gagal melakukan registrasi';
                        // Tambahkan log error
                        error_log("Gagal registrasi untuk username: $username");
                    }
                }
            }
        }
    } catch(PDOException $e) {
        $error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
        // Tambahkan log error
        error_log("Error PDO: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CyberOnly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #10B981;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 15px;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .register-header i {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .register-body {
            padding: 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #eee;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px;
            color: white;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
        }

        .btn-register:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <i class="fas fa-user-plus"></i>
                <h3 class="mb-0">Register CyberOnly</h3>
            </div>
            <div class="register-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                        <br>
                        <a href="login.php" class="alert-link">Klik disini untuk login</a>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Username" required>
                        <label for="username">Username</label>
                    </div>
                    
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">Password</label>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
                    </div>
                    
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               placeholder="Konfirmasi Password" required>
                        <label for="confirm_password">Konfirmasi Password</label>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('confirm_password')"></i>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp" 
                               placeholder="Nomor WhatsApp" required>
                        <label for="whatsapp">Nomor WhatsApp</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Email" required>
                        <label for="email">Email</label>
                    </div>
                    
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </form>
                
                <div class="login-link">
                    Sudah punya akun? <a href="login.php">Login disini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = passwordInput.nextElementSibling.nextElementSibling;
            
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