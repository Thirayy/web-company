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

// Ambil data user
try {
    // Ambil data user
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Ambil statistik kursus
    $stmt = $db->prepare("SELECT COUNT(*) as total_courses FROM course_registrations WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $courseStats = $stmt->fetch();

    // Ambil kursus terakhir
    $stmt = $db->prepare("
        SELECT c.* FROM courses c 
        JOIN course_registrations cr ON c.id = cr.course_id 
        WHERE cr.user_id = ? 
        ORDER BY cr.registration_date DESC LIMIT 3
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $recentCourses = $stmt->fetchAll();

} catch(PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

include 'header.php';
?>

<div class="profile-page">
    <!-- Profile Header -->
    <div class="profile-header parallax-section" data-speed="0.5">
        <div class="container">
            <div class="profile-header-content">
                <div class="profile-avatar parallax-item" data-depth="0.2">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-info">
                    <h1 class="gradient-text"><?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?></h1>
                    <p class="user-role"><i class="fas fa-shield-alt me-2"></i><?php echo ucfirst($user['role']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Profile Stats -->
            <div class="col-md-4">
                <div class="profile-card stats-card parallax-item" data-depth="0.1">
                    <div class="card-body">
                        <h3>Statistik Akun</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <i class="fas fa-graduation-cap"></i>
                                <div class="stat-info">
                                    <h4><?php echo $courseStats['total_courses']; ?></h4>
                                    <p>Kursus Terdaftar</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <div class="stat-info">
                                    <h4><?php echo floor((time() - strtotime($user['created_at'])) / (60*60*24)); ?></h4>
                                    <p>Hari Bergabung</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <div class="stat-info">
                                    <h4>Level 1</h4>
                                    <p>Status Member</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="col-md-8">
                <div class="profile-card info-card parallax-item" data-depth="0.2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>Informasi Profil</h3>
                            <button class="btn btn-edit" onclick="toggleEdit()">
                                <i class="fas fa-edit"></i> Edit Profil
                            </button>
                        </div>
                        
                        <form method="POST" action="" id="profileForm">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                                        <small class="text-muted">Username tidak dapat diubah</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="full_name" class="form-control profile-input" 
                                               value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control profile-input" 
                                               value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>WhatsApp</label>
                                        <input type="tel" name="whatsapp" class="form-control profile-input" 
                                               value="<?php echo htmlspecialchars($user['whatsapp']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-12 text-end save-button" style="display: none;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-12">
                <div class="profile-card activity-card parallax-item" data-depth="0.3">
                    <div class="card-body">
                        <h3>Aktivitas Terakhir</h3>
                        <div class="timeline">
                            <?php foreach($recentCourses as $course): ?>
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                                        <span class="timeline-date">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            <?php echo date('d M Y', strtotime($course['created_at'])); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12">
                <div class="profile-card actions-card parallax-item" data-depth="0.2">
                    <div class="card-body">
                        <h3>Aksi Cepat</h3>
                        <div class="quick-actions">
                            <a href="my_courses.php" class="action-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Kursus Saya</span>
                            </a>
                            <a href="change_password.php" class="action-item">
                                <i class="fas fa-key"></i>
                                <span>Ubah Password</span>
                            </a>
                            <a href="contact.php" class="action-item">
                                <i class="fas fa-headset"></i>
                                <span>Bantuan</span>
                            </a>
                            <a href="logout.php" class="action-item text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Page Styles */
.profile-page {
    padding-top: 80px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
}

/* Profile Header */
.profile-header {
    background: linear-gradient(135deg, #4F46E5, #10B981);
    padding: 60px 0;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    opacity: 0.2;
}

.profile-header-content {
    display: flex;
    align-items: center;
    gap: 30px;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.3), rgba(16, 185, 129, 0.3));
    border: 3px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.1) rotate(5deg);
    border-color: rgba(255, 255, 255, 0.4);
}

.profile-info h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.user-role {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Profile Cards */
.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(79, 70, 229, 0.15);
    border-color: rgba(79, 70, 229, 0.2);
}

.profile-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--primary-color);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.stat-item:hover {
    transform: translateX(10px);
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    border-color: rgba(79, 70, 229, 0.2);
}

.stat-item i {
    font-size: 1.5rem;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    width: 50px;
    height: 50px;
    background-color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-info h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-info p {
    margin: 0;
    color: #666;
}

/* Timeline */
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    padding: 20px;
    border-radius: 15px;
    position: relative;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.timeline-content:hover {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(16, 185, 129, 0.08));
    border-color: rgba(79, 70, 229, 0.2);
}

.timeline-content::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 50%;
    transform: translateY(-50%);
    border-style: solid;
    border-width: 10px 10px 10px 0;
    border-color: transparent rgba(79, 70, 229, 0.05) transparent transparent;
}

.timeline-date {
    font-size: 0.9rem;
    color: #666;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.action-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    border-radius: 15px;
    color: var(--dark-color);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.action-item:hover {
    transform: translateY(-5px);
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    border-color: rgba(79, 70, 229, 0.2);
    color: #4F46E5;
}

.action-item i {
    font-size: 1.5rem;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Form Controls */
.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 2px solid #eee;
}

.form-control:disabled {
    background: #f8f9fa;
}

.btn-edit {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    color: #4F46E5;
    border: 1px solid rgba(79, 70, 229, 0.2);
    padding: 8px 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-edit:hover {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(16, 185, 129, 0.2));
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #4F46E5, #10B981);
    border: none;
    padding: 12px 25px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

/* Dark Mode */
.dark-mode .profile-card {
    background: #2D3748;
    color: white;
}

.dark-mode .stat-item,
.dark-mode .timeline-content,
.dark-mode .action-item {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    border-color: rgba(255, 255, 255, 0.1);
}

.dark-mode .stat-item:hover,
.dark-mode .action-item:hover {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(16, 185, 129, 0.15));
    border-color: rgba(255, 255, 255, 0.2);
}

.dark-mode .form-control:disabled {
    background: #4A5568;
    color: #CBD5E0;
}

.dark-mode .stat-info p,
.dark-mode .timeline-date {
    color: #CBD5E0;
}

/* Gradient Text */
.gradient-text {
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
}

/* Card Shadows */
.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(79, 70, 229, 0.15);
    border-color: rgba(79, 70, 229, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-header-content {
        flex-direction: column;
        text-align: center;
    }

    .quick-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function toggleEdit() {
    const inputs = document.querySelectorAll('.profile-input');
    const saveButton = document.querySelector('.save-button');
    
    inputs.forEach(input => {
        input.disabled = !input.disabled;
    });
    
    saveButton.style.display = inputs[0].disabled ? 'none' : 'block';
}

// Initialize parallax effect
document.addEventListener('DOMContentLoaded', function() {
    const parallaxItems = document.querySelectorAll('.parallax-item');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        
        parallaxItems.forEach(item => {
            const speed = parseFloat(item.getAttribute('data-depth')) || 0.2;
            const yPos = -(scrolled * speed);
            item.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    });
});
</script>

<?php include 'footer.php'; ?> 