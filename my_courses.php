<?php
session_start();
include 'header.php';
require_once 'config/database.php';

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    // Ambil semua kursus yang diikuti user
    $stmt = $db->prepare("
        SELECT c.*, uc.enrolled_at, uc.status 
        FROM user_courses uc 
        JOIN courses c ON uc.course_id = c.id 
        WHERE uc.user_id = ? 
        ORDER BY uc.enrolled_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $enrolled_courses = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div class="my-courses-page py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Kursus Saya</h2>

        <?php if (empty($enrolled_courses)): ?>
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h3>Belum Ada Kursus</h3>
                <p class="text-muted">Anda belum mengikuti kursus apapun</p>
                <a href="edukasi.php" class="btn btn-primary mt-3">
                    <i class="fas fa-search me-2"></i>Cari Kursus
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($enrolled_courses as $course): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="course-card h-100">
                            <div class="course-image">
                                <img src="<?php echo $course['image']; ?>" alt="<?php echo $course['title']; ?>">
                                <div class="course-progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <span class="progress-text">0% Selesai</span>
                                </div>
                            </div>
                            <div class="course-content">
                                <div class="course-info">
                                    <span class="course-category">
                                        <i class="<?php 
                                            switch($course['category']) {
                                                case 'network_security': echo 'fas fa-shield-alt'; break;
                                                case 'network_infrastructure': echo 'fas fa-network-wired'; break;
                                                case 'password_maintenance': echo 'fas fa-key'; break;
                                                case 'linux_basics': echo 'fab fa-linux'; break;
                                                case 'phishing_education': echo 'fas fa-fish'; break;
                                                case 'malware_basics': echo 'fas fa-bug'; break;
                                                default: echo 'fas fa-book';
                                            }
                                        ?> me-2"></i>
                                        <?php echo $course['category']; ?>
                                    </span>
                                    <?php if($course['is_free']): ?>
                                        <span class="badge bg-success">Gratis</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Premium</span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="course-title"><?php echo $course['title']; ?></h3>
                                <div class="course-meta">
                                    <span><i class="fas fa-clock me-2"></i><?php echo $course['duration']; ?> Jam</span>
                                    <span><i class="fas fa-book me-2"></i><?php echo $course['modules']; ?> Modul</span>
                                </div>
                                <div class="course-footer">
                                    <span class="enrollment-date">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Terdaftar: <?php echo date('d M Y', strtotime($course['enrolled_at'])); ?>
                                    </span>
                                    <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-play me-2"></i>Lanjutkan Belajar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* My Courses Page Styles */
.my-courses-page {
    background-color: var(--light-color);
}

.course-card {
    background: var(--white-color);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.course-image {
    position: relative;
    height: 200px;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
}

.progress {
    height: 8px;
    border-radius: 4px;
    background: rgba(255,255,255,0.2);
    margin-bottom: 0.5rem;
}

.progress-bar {
    background: var(--secondary-color);
}

.progress-text {
    font-size: 0.9rem;
    font-weight: 500;
}

.course-content {
    padding: 1.5rem;
}

.course-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.course-category {
    color: var(--primary-color);
    font-size: 0.9rem;
}

.course-title {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: var(--dark-color);
}

.course-meta {
    display: flex;
    gap: 1rem;
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.enrollment-date {
    font-size: 0.9rem;
    color: #666;
}

/* Dark Mode */
.dark-mode .my-courses-page {
    background-color: var(--dark-color);
}

.dark-mode .course-card {
    background: #2D3748;
}

.dark-mode .course-title {
    color: var(--light-color);
}

.dark-mode .course-meta,
.dark-mode .enrollment-date {
    color: #CBD5E0;
}

.dark-mode .course-footer {
    border-color: rgba(255,255,255,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .course-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .course-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>

<?php include 'footer.php'; ?> 