<?php
require_once 'config/database.php';

// Ambil ID kursus dari parameter URL
$course_id = isset($_GET['id']) ? $_GET['id'] : 0;

try {
    // Ambil detail kursus berdasarkan ID
    $stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch();

    if (!$course) {
        echo "<div class='alert alert-danger'>Kursus tidak ditemukan.</div>";
        exit();
    }

    // Ambil modul kursus dari database (periksa nama tabel)
    $stmt = $db->prepare("SELECT * FROM course_modules WHERE course_id = ?"); // Ensure this matches your actual table name
    $stmt->execute([$course_id]);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title'] ?? 'Kursus Tidak Ditemukan'); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .course-header {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            padding: 60px 0;
            text-align: center;
            border-radius: 0 0 20px 20px;
            margin-bottom: 40px;
        }
        .module-card {
            margin-bottom: 30px;
            transition: transform 0.2s;
        }
        .module-card:hover {
            transform: scale(1.05);
        }
        .btn-enroll {
            background-color: #28a745;
            color: white;
        }
        .btn-enroll:hover {
            background-color: #218838;
        }
        .module-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .module-content {
            font-size: 0.9rem;
            color: #555;
        }
        .module-duration {
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>

<div class="course-header">
    <h1><?php echo htmlspecialchars($course['title'] ?? 'Kursus Tidak Ditemukan'); ?></h1>
    <p><?php echo htmlspecialchars($course['description'] ?? 'Deskripsi tidak tersedia.'); ?></p>
    <h5><i class="fa fa-clock"></i> Durasi: <?php echo htmlspecialchars($course['duration'] ?? 'N/A'); ?> Jam</h5>
    <h5><i class="fa fa-book"></i> Modul: <?php echo htmlspecialchars($course['modules'] ?? 'N/A'); ?></h5>
    <h5><i class="fa fa-signal"></i> Level: <?php echo ucfirst(htmlspecialchars($course['level'] ?? 'N/A')); ?></h5>
    <a href="enroll.php?id=<?php echo $course_id; ?>" class="btn btn-enroll btn-lg">Daftar Kursus</a>
</div>

<div class="container">
    <h2 class="mb-4">Modul Pembelajaran</h2>
    <div class="row">
        <?php if ($modules): ?>
            <?php foreach ($modules as $module): ?>
                <div class="col-md-4">
                    <div class="card module-card shadow-sm">
                        <div class="card-body">
                            <h5 class="module-title"><?php echo htmlspecialchars($module['title'] ?? 'Judul tidak tersedia'); ?></h5>
                            <p class="module-content"><?php echo htmlspecialchars($module['content'] ?? 'Konten tidak tersedia.'); ?></p>
                            <p class="module-duration"><strong>Durasi:</strong> <?php echo htmlspecialchars($module['duration'] ?? 'N/A'); ?> menit</p>
                            <a href="#module<?php echo $module['id']; ?>" class="btn btn-primary" data-toggle="collapse">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">Tidak ada modul yang ditemukan untuk kursus ini.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 