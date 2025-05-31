<?php 
session_start();
include 'header.php'; 
require_once 'config/database.php'; 

// Initialize variables
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Default to an empty string if not set
$category = isset($_GET['category']) ? $_GET['category'] : 'all'; // Default to 'all' if not set
$is_free = isset($_GET['is_free']) ? $_GET['is_free'] : null; // Initialize as null if not set

// Build query
$query = "SELECT * FROM courses WHERE status = 'active'";

// If no search term is provided, order by random
if (empty($search)) {
    $query .= " ORDER BY RAND()"; // Random order for default display
} else {
    if ($category !== 'all') {
        $query .= " AND category = :category";
    }
    if (isset($is_free)) {
        $query .= " AND is_free = :is_free";
    }
    if ($search) {
        $query .= " AND (title LIKE :search OR description LIKE :search)";
    }
    $query .= " ORDER BY created_at DESC"; // Order by created_at for search results
}
    
try {
    $stmt = $db->prepare($query);
    
    // Bind parameters
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    if ($category !== 'all') {
        $stmt->bindParam(':category', $category);
    }
    if (isset($is_free)) {
        $stmt->bindParam(':is_free', $is_free, PDO::PARAM_BOOL);
    }
    
    $stmt->execute();
    $courses = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    $courses = []; // Initialize $courses as an empty array in case of an error
}


$query_vidio = "SELECT * FROM vidio WHERE status = 'active'";

try {
    $stmt_vidio = $db->prepare($query_vidio);
    $stmt_vidio->execute();
    $videos = $stmt_vidio->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    $videos = []; // Initialize $videos as an empty array in case of an error
}
?>

<!-- Hero Section -->
<div class="hero-education position-relative">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row min-vh-50 align-items-center py-5">
            <div class="col-lg-8 text-center mx-auto" data-aos="fade-up">
                <h1 class="display-4 fw-bold text-white mb-4">Edukasi Keamanan Cyber</h1>
                <p class="lead text-white-50 mb-4">Tingkatkan pemahaman dan keterampilan keamanan siber Anda bersama CyberOnly</p>
                <div class="search-box">
                    <form action="" method="GET" class="d-flex justify-content-center gap-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari kursus..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<section class="courses-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">Kursus Kami</h2>
        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3>Tidak ada kursus ditemukan</h3>
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($courses as $course): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-lg border-light course-card">
                            <img src="<?php echo htmlspecialchars($course['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>" loading="lazy">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                <p class="card-text">
                                    <strong>Deskripsi:</strong> <?php echo htmlspecialchars($course['description']); ?>
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong>Durasi:</strong> <?php echo htmlspecialchars($course['duration']); ?> Jam
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-tag me-1"></i>
                                    <strong>Harga:</strong> 
                                    <?php echo $course['is_free'] ? "Gratis" : "Rp " . number_format($course['price'], 0, ',', '.'); ?>
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-star me-1"></i>
                                    <strong>Tingkat:</strong> <?php echo htmlspecialchars($course['level']); ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <?php if(isset($_SESSION['user_id'])): ?>
                                    <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary enroll-module" data-course-id="<?php echo $course['id']; ?>" data-is-free="<?php echo $course['is_free']; ?>">Daftar Kursus</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login untuk Daftar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Videos Section -->
<section class="videos-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">Video Edukasi</h2>
        <?php if (empty($videos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-video fa-3x text-muted mb-3"></i>
                <h3>Tidak ada video ditemukan</h3>
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($videos as $video): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-lg border-light video-card">
                            <iframe src="<?php echo htmlspecialchars($video['url']); ?>" class="card-img-top" frameborder="0" allowfullscreen loading="lazy"></iframe>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($video['title']); ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom CSS -->
<style>
.hero-education {
    background: url('path/to/your/background-image.jpg') no-repeat center center/cover; /* Background image */
    padding: 100px 0; /* Adjust padding for hero section */
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5); /* Dark overlay for better text contrast */
}

.course-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px; /* Rounded corners */
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
}

.card-body {
    padding: 1.5rem; /* Increase padding for a more spacious look */
}

.card-title {
    font-size: 1.25rem; /* Adjust title size */
    font-weight: bold;
}

.card-text {
    font-size: 0.9rem; /* Adjust text size */
}

.search-box {
    margin-bottom: 20px;
}

.video-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px; /* Rounded corners */
}

.video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
}

.video-card iframe {
    width: 100%; /* Full width */
    height: 200px; /* Set height for video */
}
</style>

<script>
$(document).ready(function() {
    // Tangani klik tombol daftar modul
    $('.enroll-module').click(function() {
        const courseId = $(this).data('course-id'); // Ambil ID kursus dari data attribute
        const isFree = $(this).data('is-free'); // Ambil status gratis dari data attribute
        
        // Tampilkan loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang mendaftarkan kursus',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });
        
        // Kirim request AJAX untuk mendaftar
        $.ajax({
            type: 'POST',
            url: 'process/enroll_course.php', // Ganti dengan path yang sesuai
            data: { 
                course_id: courseId,
                is_free: isFree
            },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    // Redirect ke halaman detail kursus
                    window.location.href = 'course_detail.php?id=' + courseId;
                } else {
                    // Tampilkan notifikasi error
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Terjadi kesalahan saat mendaftar kursus',
                        confirmButtonColor: '#4F46E5'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Tampilkan notifikasi error sistem
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi nanti.',
                    confirmButtonColor: '#4F46E5'
                });
                console.error('Error:', error);
            }
        });
    });
});
</script>
