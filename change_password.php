<?php
session_start();
require_once 'config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Ambil data user
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Validasi input
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = 'Semua field harus diisi';
        }
        // Validasi password lama
        else if (!password_verify($current_password, $user['password'])) {
            $error = 'Password saat ini tidak sesuai';
        }
        // Validasi password baru
        else if (strlen($new_password) < 6) {
            $error = 'Password baru minimal 6 karakter';
        }
        // Validasi konfirmasi password
        else if ($new_password !== $confirm_password) {
            $error = 'Konfirmasi password tidak cocok';
        }
        else {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                ':password' => $hashed_password,
                ':id' => $_SESSION['user_id']
            ]);

            if ($result) {
                $success = 'Password berhasil diubah!';
            } else {
                $error = 'Gagal mengubah password';
            }
        }
    } catch(PDOException $e) {
        $error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
    }
}

include 'header.php';
?>

<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card password-card">
                <div class="card-header text-center py-4">
                    <div class="password-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 class="mt-3 mb-0">Ubah Password</h4>
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-4 position-relative">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
                        </div>

                        <div class="mb-4 position-relative">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
                        </div>

                        <div class="mb-4 position-relative">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Password Baru
                            </button>
                            <a href="profile.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.password-card {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 15px;
    overflow: hidden;
}

.password-card .card-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
}

.password-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.password-icon i {
    font-size: 2rem;
    color: white;
}

.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 2px solid #eee;
    padding-right: 40px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 45px;
    cursor: pointer;
    color: #666;
}

.btn {
    padding: 12px;
    border-radius: 10px;
    font-weight: 500;
}

/* Dark Mode Adjustments */
.dark-mode .password-card {
    background: #2D3748;
    color: white;
}

.dark-mode .form-control {
    background: #1A202C;
    border-color: #4A5568;
    color: white;
}

.dark-mode .password-toggle {
    color: #CBD5E0;
}
</style>

<script>
function togglePassword(icon) {
    const input = icon.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

<?php include 'footer.php'; ?> 