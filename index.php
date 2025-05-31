<?php 
session_start();
include 'header.php'; 
require_once 'config/database.php'; 

// Fetch courses for the education section
try {
    $stmt = $db->query("SELECT * FROM courses WHERE status = 'active' ORDER BY RAND() LIMIT 5"); // Get 5 random courses
    $courses = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    $courses = []; // Initialize $courses as an empty array in case of an error
}
?>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold mb-4">CyberOnly</h1>
                        <p class="lead mb-4">Melindungi infrastruktur digital Anda dengan layanan keamanan cyber profesional yang komprehensif dan terpercaya.</p>
                        <div class="d-flex gap-3">
                            <a href="#services" class="btn btn-primary">Lihat Layanan</a>
                            <a href="#contact" class="btn btn-outline-light">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="text-center">
                        <img src="assets/New folder/logo.png" alt="Security Icon" class="img-fluid logo-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-4">
        <div class="container">
            <h2 class="text-center mb-4 pt-3" data-aos="fade-up">Tentang Kami</h2>
            <div class="row g-4 align-items-center mb-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="text-center">
                        <img src="assets/New folder/workteam.jpg" alt="Tim Keamanan Kami" class="img-fluid team-image">
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-4">Solusi Keamanan Cyber Terdepan</h3>
                            <p class="lead">Dengan pengalaman lebih dari 10 tahun dalam industri keamanan cyber, kami telah membantu ratusan perusahaan dalam mengamankan aset digital mereka dari berbagai ancaman siber.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-shield-alt text-primary me-3 fa-2x"></i>
                        <div>
                            <h4 class="h5 mb-1">Keamanan 24/7</h4>
                            <p class="mb-0">Monitoring dan perlindungan non-stop</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-certificate text-primary me-3 fa-2x"></i>
                        <div>
                            <h4 class="h5 mb-1">Tim Tersertifikasi</h4>
                            <p class="mb-0">Ahli keamanan dengan sertifikasi internasional</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Layanan Kami</h2>
            <div class="row g-4">
                <?php
                try {
                    $stmt = $db->query("SELECT * FROM services WHERE status = 'active' ORDER BY id LIMIT 6");
                    $services = $stmt->fetchAll();
                    
                    foreach($services as $service): 
                        $features = json_decode($service['features'], true);
                ?>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100 service-card">
                        <img src="<?php echo $service['image']; ?>" 
                             class="card-img-top" 
                             alt="<?php echo $service['title']; ?>"
                             loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $service['title']; ?></h5>
                            <p class="card-text"><?php echo $service['description']; ?></p>
                            <div class="mt-3">
                                <a href="services.php" class="btn btn-primary w-100">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Edukasi Keamanan Cyber</h2>
            
            <!-- Slider Container -->
            <div class="swiper-container education-slider" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php foreach($courses as $course): ?>
                        <div class="swiper-slide">
                            <div class="edu-card">
                                <div class="edu-card-image">
                                    <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                                </div>
                                <div class="edu-card-content">
                                    <h5><?php echo htmlspecialchars($course['title']); ?></h5>
                                    <p><?php echo htmlspecialchars($course['description']); ?></p>
                                    <div class="edu-price">
                                        <span class="price">Rp <?php echo number_format($course['price'], 0, ',', '.'); ?></span>
                                        <?php if(isset($_SESSION['user_id'])): ?>
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fas fa-graduation-cap me-1"></i>Ayo Belajar
                                            </a>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-primary btn-sm">
                                                <i class="fas fa-lock me-1"></i>Ayo Belajar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="edukasi.php" class="btn btn-view-all">
                    <span>Lihat Semua Kursus</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Add Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.education-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            }
        }
    });
    </script>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Hubungi Kami</h2>
            <div class="row">
                <div class="col-md-6" data-aos="fade-right">
                    <form id="contactForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" placeholder="No WhatsApp" pattern="[0-9]+" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="4" placeholder="Pesan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="contact-info">
                        <h4>Informasi Kontak</h4>
                        <p><i class="fas fa-map-marker-alt"></i> Jl. Keamanan Cyber No. 123, Jakarta</p>
                        <p><i class="fas fa-phone"></i> +62 123 4567 890</p>
                        <p><i class="fas fa-envelope"></i> info@cyberonly.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>

<style>
/* Education Section Styles */
.edu-card {
    background: #2D3748;
    border-radius: 15px;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.edu-card:hover {
    transform: translateY(-10px);
}

.edu-card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.edu-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.edu-card:hover .edu-card-image img {
    transform: scale(1.1);
}

.edu-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.edu-card-content {
    padding: 20px;
    color: white;
}

.edu-card-content h5 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: white;
}

.edu-card-content p {
    font-size: 0.9rem;
    color: #CBD5E0;
    margin-bottom: 15px;
    line-height: 1.6;
}

.edu-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #CBD5E0;
    margin-bottom: 20px;
}

.edu-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
}

.edu-meta i {
    color: var(--primary-color);
}

.edu-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 15px;
    margin-top: auto;
    gap: 10px;
}

.price {
    font-size: 0.9rem;
    font-weight: 600;
    color: white;
    background: var(--primary-color);
    padding: 6px 12px;
    border-radius: 20px;
    white-space: nowrap;
    min-width: fit-content;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.9rem;
    border-radius: 20px;
    white-space: nowrap;
    min-width: fit-content;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .edu-card-image {
        height: 180px;
    }
    
    .edu-card-content {
        padding: 15px;
    }
    
    .edu-card-content h5 {
        font-size: 1.1rem;
    }
    
    .edu-meta {
        font-size: 0.8rem;
    }
}

/* Add Slider Specific Styles */
.education-slider {
    padding: 30px 60px;
    margin: 30px 0;
    position: relative;
    overflow: hidden;
}

.swiper-slide {
    transition: visibility 0.3s, opacity 0.3s;
}

.swiper-slide-active {
    opacity: 1 !important;
    transform: scale(1) !important;
}

.swiper-button-next,
.swiper-button-prev {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-radius: 50%;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
    transition: all 0.3s ease;
    z-index: 10;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 18px;
    font-weight: bold;
}

/* Hover effect */
.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: white;
    color: var(--primary-color);
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(79, 70, 229, 0.4);
}

/* Disabled state */
.swiper-button-disabled {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)) !important;
    color: white !important;
    transform: scale(0.9) !important;
}

/* Position adjustments */
.swiper-button-next {
    right: 10px;
}

.swiper-button-prev {
    left: 10px;
}

/* Dark mode adjustments */
.dark-mode .swiper-button-next,
.dark-mode .swiper-button-prev {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.dark-mode .swiper-button-next:hover,
.dark-mode .swiper-button-prev:hover {
    background: #2D3748;
    color: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .swiper-button-next,
    .swiper-button-prev {
        width: 35px;
        height: 35px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 14px;
    }
}

.swiper-pagination {
    position: relative;
    margin-top: 25px;
}

.swiper-pagination-bullet {
    width: 6px;
    height: 6px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0.3;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    transform: scale(1.2);
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

/* Add focus styles for accessibility */
.swiper-button-next:focus,
.swiper-button-prev:focus,
.swiper-pagination-bullet:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* Dark mode adjustments */
.dark-mode .swiper-button-next,
.dark-mode .swiper-button-prev {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.dark-mode .swiper-button-next:hover,
.dark-mode .swiper-button-prev:hover {
    background: #2D3748;
    color: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .education-slider {
        padding: 20px 40px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 35px;
        height: 35px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 14px;
    }
}

/* Slide Animation */
.swiper-slide {
    opacity: 0.4;
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.swiper-slide-active {
    opacity: 1;
    transform: scale(1);
}

.swiper-slide-active .edu-card {
    animation: cardPop 0.5s ease forwards;
}

/* Dark Mode */
.dark-mode .swiper-button-next,
.dark-mode .swiper-button-prev {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.dark-mode .swiper-button-next:hover,
.dark-mode .swiper-button-prev:hover {
    background: #2D3748;
    color: var(--primary-color);
}

/* Custom Animations */
@keyframes cardPop {
    0% {
        transform: scale(0.95);
    }
    50% {
        transform: scale(1.02);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .education-slider {
        padding: 0 40px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 16px;
    }
    
    .swiper-pagination-bullet {
        width: 20px;
        height: 4px;
    }
    
    .swiper-pagination-bullet-active {
        width: 30px;
    }
}

/* Update pagination styles */
.swiper-pagination {
    position: relative;
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 8px;
}

.swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--primary-color);
    opacity: 0.3;
    transition: all 0.3s ease;
    cursor: pointer;
    padding: 0;
    margin: 0;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: var(--primary-color);
    transform: scale(1.2);
}

/* Hover effect for pagination bullets */
.swiper-pagination-bullet:hover {
    opacity: 0.8;
}

/* Limit total bullets to 5 */
.swiper-pagination-bullet:nth-child(n+6) {
    display: none;
}

/* Update CSS di index.php */
@media (max-width: 768px) {
    .swiper-slide .edu-card-image {
        height: 180px;
    }
    
    .swiper-slide .edu-card-content {
        padding: 15px;
    }
    
    .swiper-slide .edu-card-content h5 {
        font-size: 1.1rem;
    }
    
    .swiper-slide .edu-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .swiper-slide .edu-price {
        flex-direction: row;
        flex-wrap: nowrap;
        gap: 8px;
    }
    
    .swiper-slide .price {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
    
    .swiper-slide .btn-sm {
        padding: 5px 10px;
        font-size: 0.75rem;
        min-width: 80px;
        white-space: nowrap;
    }

    /* Adjust slider navigation for mobile */
    .education-slider {
        padding: 0 30px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 35px;
        height: 35px;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .edu-price {
        gap: 6px;
    }
    
    .price {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
    
    .btn-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
    }
}

/* Style untuk tombol Lihat Semua Kursus */
.btn-view-all {
    position: relative;
    padding: 15px 30px;
    font-size: 1rem;
    font-weight: 600;
    color: white;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    border-radius: 50px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

.btn-view-all span {
    position: relative;
    z-index: 1;
    margin-right: 10px;
}

.btn-view-all i {
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.btn-view-all::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Hover Effects */
.btn-view-all:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

.btn-view-all:hover::before {
    opacity: 1;
}

.btn-view-all:hover i {
    transform: translateX(5px);
}

/* Active state */
.btn-view-all:active {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

/* Dark Mode Adjustments */
.dark-mode .btn-view-all {
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
}

.dark-mode .btn-view-all:hover {
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

/* Animation */
@keyframes pulse {
    0% {
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }
    50% {
        box-shadow: 0 5px 25px rgba(79, 70, 229, 0.5);
    }
    100% {
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }
}

.btn-view-all {
    animation: pulse 2s infinite;
}

.btn-view-all:hover {
    animation: none;
}

/* Update style untuk tombol navigasi */
.swiper-button-next,
.swiper-button-prev {
    transition: all 0.3s ease;
}

.swiper-button-next.swiper-button-disabled,
.swiper-button-prev.swiper-button-disabled {
    transform: scale(0.9);
}

/* Style untuk bullets */
.swiper-pagination {
    position: relative;
    margin-top: 25px;
    display: flex;
    justify-content: center;
    gap: 6px;
    z-index: 1;
}

.swiper-pagination-bullet {
    width: 6px;
    height: 6px;
    background: rgba(79, 70, 229, 0.3);
    border-radius: 50%;
    transition: all 0.3s ease;
    cursor: pointer;
    opacity: 1;
    margin: 0 !important;
}

.swiper-pagination-bullet-active {
    background: var(--primary-color);
    transform: scale(1.2);
}

/* Hover effect untuk bullets */
.swiper-pagination-bullet:hover {
    background: rgba(79, 70, 229, 0.6);
}

/* Update style untuk navigation buttons */
.swiper-button-next,
.swiper-button-prev {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    top: 45%;
}

.swiper-button-next {
    right: 0;
}

.swiper-button-prev {
    left: 0;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 16px;
    font-weight: bold;
}

/* Hide bullets yang tidak perlu */
.swiper-pagination-bullet:nth-child(n+4) {
    display: none;
}

/* Dark mode adjustments */
.dark-mode .swiper-pagination-bullet {
    background: rgba(255, 255, 255, 0.3);
}

.dark-mode .swiper-pagination-bullet-active {
    background: var(--primary-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .swiper-pagination-bullet {
        width: 5px;
        height: 5px;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 35px;
        height: 35px;
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 14px;
    }
}

body {
    font-family: 'Roboto', sans-serif; /* Use a modern font */
    background-color: #f8f9fa; /* Light background for better contrast */
}

.navbar {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for navbar */
}

.card {
    border-radius: 15px; /* Rounded corners for cards */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.btn-primary {
    border-radius: 20px; /* Rounded buttons */
}

footer {
    background-color: #343a40; /* Dark footer */
    color: white; /* White text for contrast */
}

footer a {
    color: #f8f9fa; /* Light color for links */
}

footer a:hover {
    text-decoration: underline; /* Underline on hover */
}
</style>
