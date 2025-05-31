<?php
session_start();
include 'header.php';
require_once 'config/database.php';

// Ambil ID kursus dari parameter URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id === 0) {
    echo "<div class='alert alert-danger'>ID kursus tidak valid.</div>";
    exit();
}

try {
    // Ambil detail kursus berdasarkan ID
    $stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch();

    if (!$course) {
        echo "<div class='alert alert-danger'>Kursus tidak ditemukan.</div>";
        exit();
    }

    // Ambil modul kursus dari database
    $stmt = $db->prepare("SELECT * FROM course_modules WHERE course_id = ?");
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
    <title><?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --bg-color-light: #f8f9fa;
            --bg-color-dark: #343a40;
            --text-color-light: #343a40;
            --text-color-dark: #f8f9fa;
            --card-bg-light: #ffffff;
            --card-bg-dark: #495057;
            --header-bg: #007bff;
        }

        body {
            background-color: var(--bg-color-light);
            color: var(--text-color-light);
            padding-top: 70px;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .course-header {
            background-color: var(--header-bg);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .module-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            background-color: var(--card-bg-light);
            border: 1px solid #e0e0e0;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .faq {
            margin-top: 40px;
        }

        .content-section {
            margin-bottom: 40px;
        }

        /* Dark mode styles */
        body.dark-mode {
            background-color: var(--bg-color-dark);
            color: var(--text-color-dark);
        }

        .card.dark-mode {
            background-color: var(--card-bg-dark);
        }

        .testimonial.dark-mode {
            background-color: #6c757d;
        }

        .icon {
            font-size: 1.5rem;
            color: var(--header-bg);
            margin-right: 10px;
        }

        .module-icon {
            font-size: 1.2rem;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="course-header">
        <h1><i class="fas fa-graduation-cap icon"></i><?php echo htmlspecialchars($course['title']); ?></h1>
        <p><?php echo htmlspecialchars($course['description']); ?></p>
    </div>

    <div class="content-section">
        <h5><strong><i class="fas fa-clock"></i> Durasi:</strong> <?php echo htmlspecialchars($course['duration']); ?> Jam</h5>
        <h5><strong><i class="fas fa-level-up-alt"></i> Level:</strong> <?php echo ucfirst($course['level']); ?></h5>
    </div>

    <div class="content-section">
        <h2 class="mt-4"><i class="fas fa-book-open"></i> Modul Pembelajaran</h2>
        <div class="row">
            <?php if ($modules): ?>
                <?php foreach ($modules as $module): ?>
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="module-title"><i class="fas fa-book module-icon"></i><?php echo htmlspecialchars($module['title']); ?></h5>
                                <p><?php echo nl2br(htmlspecialchars($module['content'])); ?></p>
                                <p class="module-duration"><strong><i class="fas fa-clock"></i> Durasi:</strong> <?php echo htmlspecialchars($module['duration']); ?> menit</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">Tidak ada modul yang ditemukan untuk kursus ini.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="faq mt-4">
        <h3><i class="fas fa-question-circle"></i> Pertanyaan yang Sering Diajukan (FAQ)</h3>
        <div class="mb-3">
            <strong>Q: Apakah ada syarat untuk mendaftar?</strong>
            <p>A: Tidak ada syarat khusus, semua orang dapat mendaftar.</p>
        </div>
        <div class="mb-3">
            <strong>Q: Berapa lama akses ke materi kursus?</strong>
            <p>A: Anda akan memiliki akses seumur hidup ke materi kursus setelah mendaftar.</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<?php include 'footer.php'; ?>