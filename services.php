<?php 
include 'header.php';
require_once 'config/database.php';

// Ambil data services dari database
try {
    $stmt = $db->query("SELECT * FROM services WHERE status = 'active' ORDER BY id");
    $services = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- Hero Section -->
<div class="hero-services position-relative">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row min-vh-50 align-items-center py-5">
            <div class="col-lg-8 text-center mx-auto" data-aos="fade-up">
                <h1 class="display-4 fw-bold text-white mb-4">Layanan Keamanan Cyber</h1>
                <p class="lead text-white-50 mb-4">Solusi keamanan siber terpercaya untuk melindungi bisnis Anda</p>
                <div class="hero-features d-flex justify-content-center gap-4 mt-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <p>Proteksi 24/7</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <p>Enkripsi Data</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <p>Tim Ahli</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-services {
    background: transparent;
    position: relative;
    overflow: hidden;
    padding: 120px 0 80px;
    opacity: 0.9;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('assets/New folder/logo service.jpg') center/cover;
    opacity: 0.1;
}

.feature-item {
    text-align: center;
    color: white;
    transition: all 0.3s ease;
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    transition: all 0.3s ease;
}

.feature-icon i {
    font-size: 30px;
    color: white;
}

.feature-item:hover .feature-icon {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.2);
}

.feature-item p {
    font-size: 0.9rem;
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
    .feature-icon {
        width: 60px;
        height: 60px;
    }
    
    .feature-icon i {
        font-size: 24px;
    }
    
    .feature-item p {
        font-size: 0.8rem;
    }
}

/* Service Card Styles */
.service-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
}

.service-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    z-index: -1;
    transition: opacity 0.5s ease;
    border-radius: 20px;
}

.service-card:hover::before {
    opacity: 0.02;
}

.service-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.service-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.5s ease;
}

.service-overlay i {
    color: white;
    font-size: 3rem;
    transform: scale(0.5);
    transition: all 0.5s ease;
}

.service-card:hover .service-image img {
    transform: scale(1.1);
}

.service-card:hover .service-overlay {
    opacity: 1;
}

.service-card:hover .service-overlay i {
    transform: scale(1);
}

.service-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    transform: rotate(-10deg);
    transition: all 0.5s ease;
}

.service-icon i {
    color: white;
    font-size: 24px;
}

.service-card:hover .service-icon {
    transform: rotate(0deg) scale(1.1);
}

.features-list {
    margin: 20px 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    padding: 8px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: rgba(79, 70, 229, 0.1);
}

.feature-item i {
    color: var(--primary-color);
}

.price-tag {
    text-align: center;
    padding: 15px 0;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.price {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary-color);
    display: block;
}

.duration {
    font-size: 0.9rem;
    color: #666;
}

.btn-primary {
    border-radius: 10px;
    padding: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

/* Dark Mode Adjustments */
.dark-mode .service-card {
    background: #2D3748;
}

.dark-mode .feature-item:hover {
    background: rgba(255,255,255,0.1);
}

.dark-mode .price-tag {
    border-top-color: rgba(255,255,255,0.1);
}

.dark-mode .duration {
    color: #CBD5E0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .service-image {
        height: 180px;
    }
    
    .service-icon {
        width: 50px;
        height: 50px;
    }
    
    .service-icon i {
        font-size: 20px;
    }
    
    .price {
        font-size: 1.1rem;
    }
}

/* Hero Icons Style */
.hero-stats .stat-circle,
.hero-features .feature-icon {
    width: 90px;
    height: 90px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Gradient Border Effect */
.stat-circle::before,
.feature-icon::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, 
        #4F46E5, /* Primary */
        #10B981, /* Secondary */
        #3B82F6, /* Blue */
        #8B5CF6  /* Purple */
    );
    border-radius: 50%;
    z-index: -1;
    animation: borderRotate 4s linear infinite;
}

/* Icon Container */
.stat-circle::after,
.feature-icon::after {
    content: '';
    position: absolute;
    inset: 2px;
    background: rgba(45, 55, 72, 0.9);
    border-radius: 50%;
    z-index: 0;
}

/* Icon Styling */
.stat-circle i,
.feature-icon i {
    position: relative;
    z-index: 1;
    font-size: 28px;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 5px;
    transition: all 0.3s ease;
}

.stat-circle h3,
.feature-icon + p {
    position: relative;
    z-index: 1;
    color: white;
    font-weight: 600;
    margin-top: 5px;
    transition: all 0.3s ease;
}

/* Hover Effects */
.stat-circle:hover,
.feature-icon:hover {
    transform: translateY(-8px) scale(1.05);
}

.stat-circle:hover i,
.feature-icon:hover i {
    transform: scale(1.1);
    background: linear-gradient(135deg, #10B981, #4F46E5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Animations */
@keyframes borderRotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

@keyframes iconPulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

/* Hover Animation */
.stat-circle:hover i,
.feature-icon:hover i {
    animation: iconPulse 1s ease infinite;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-stats .stat-circle,
    .hero-features .feature-icon {
        width: 70px;
        height: 70px;
    }

    .stat-circle i,
    .feature-icon i {
        font-size: 22px;
    }

    .stat-circle h3 {
        font-size: 18px;
    }
}

/* Dark Mode Adjustments */
.dark-mode .stat-circle::after,
.dark-mode .feature-icon::after {
    background: rgba(26, 32, 44, 0.9);
}

.dark-mode .stat-circle i,
.dark-mode .feature-icon i {
    background: linear-gradient(135deg, #10B981, #4F46E5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Update existing service card styles */
.service-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
}

/* Update feature list styles */
.features-list {
    margin: 20px 0;
    overflow: hidden;
}

.feature-item {
    position: relative;
    cursor: pointer;
    overflow: hidden;
    margin-bottom: 15px;
    border-radius: 15px;
    background: rgba(79, 70, 229, 0.03);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(79, 70, 229, 0.1);
}

.feature-main {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    position: relative;
    z-index: 2;
    background: inherit;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    border-radius: 12px;
    transition: all 0.4s ease;
}

.feature-icon-wrapper i {
    font-size: 1.1rem;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: all 0.4s ease;
}

.feature-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.feature-title {
    font-weight: 500;
    font-size: 0.95rem;
    color: var(--dark-color);
}

.feature-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.feature-badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(16, 185, 129, 0.1));
    border-radius: 20px;
    color: var(--primary-color);
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
}

.feature-arrow {
    font-size: 0.8rem;
    color: var(--primary-color);
    transition: all 0.4s ease;
}

.feature-description {
    position: absolute;
    top: 0;
    left: 100%;
    width: 100%;
    height: 100%;
    padding: 16px;
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
}

.description-content {
    display: flex;
    gap: 15px;
    align-items: start;
    width: 100%;
}

.back-arrow {
    color: var(--primary-color);
    cursor: pointer;
    padding: 8px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.description-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 5px;
    background: linear-gradient(135deg, #4F46E5, #10B981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.feature-description p {
    margin: 0;
    font-size: 0.85rem;
    line-height: 1.6;
    color: var(--dark-color);
}

/* Hover & Active States */
.feature-item:hover {
    transform: translateX(5px);
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    border-color: rgba(79, 70, 229, 0.2);
}

.feature-item:hover .feature-badge {
    opacity: 1;
    transform: translateX(0);
}

.feature-item:hover .feature-icon-wrapper {
    background: linear-gradient(135deg, #4F46E5, #10B981);
}

.feature-item:hover .feature-icon-wrapper i {
    -webkit-text-fill-color: white;
}

.feature-item.active .feature-main {
    transform: translateX(-100%);
}

.feature-item.active .feature-description {
    transform: translateX(-100%);
}

.back-arrow:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

/* Dark Mode Adjustments */
.dark-mode .feature-item {
    background: rgba(255, 255, 255, 0.03);
    border-color: rgba(255, 255, 255, 0.1);
}

.dark-mode .feature-title {
    color: var(--light-color);
}

.dark-mode .feature-description p {
    color: var(--light-color);
}

.dark-mode .feature-badge {
    background: rgba(255, 255, 255, 0.1);
    color: var(--secondary-color);
}

.dark-mode .feature-item:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.2);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .feature-main {
        padding: 12px;
    }
    
    .feature-icon-wrapper {
        width: 32px;
        height: 32px;
    }
    
    .feature-title {
        font-size: 0.9rem;
    }
    
    .feature-badge {
        display: none;
    }
    
    .feature-description {
        padding: 12px;
    }
    
    .description-title {
        font-size: 0.85rem;
    }
    
    .feature-description p {
        font-size: 0.8rem;
    }
}

/* Update style untuk CTA Section */
.cta-section {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    padding: 80px 0;
    margin-top: 50px;
    position: relative;
    overflow: hidden;
}

.cta-wrapper {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    transform: translateY(0);
    transition: transform 0.3s ease;
}

.cta-wrapper:hover {
    transform: translateY(-10px);
}

.cta-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.gradient-text {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Stats Styles */
.stat-item {
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-align: center;
}

.stat-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    font-size: 28px;
    color: white;
}

.stat-item h3 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.stat-item p {
    color: var(--dark-color);
    font-size: 1.1rem;
    margin: 0;
}

/* Benefits Styles */
.benefit-item {
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-align: center;
    height: 100%;
}

.benefit-item i {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 20px;
}

.benefit-item h5 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--dark-color);
}

.benefit-item p {
    color: #666;
    margin: 0;
}

/* Button Styles */
.cta-buttons {
    margin-top: 40px;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 1.1rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-primary:hover,
.btn-outline-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
}

/* Dark Mode Adjustments */
.dark-mode .cta-wrapper {
    background: #2D3748;
}

.dark-mode .stat-item,
.dark-mode .benefit-item {
    background: #374151;
}

.dark-mode .stat-item p,
.dark-mode .benefit-item p {
    color: #CBD5E0;
}

.dark-mode .benefit-item h5 {
    color: white;
}

/* Animations */
.floating {
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.icon-pulse {
    animation: iconPulse 2s ease-in-out infinite;
}

@keyframes iconPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .cta-section {
        padding: 40px 0;
    }

    .gradient-text {
        font-size: 2rem;
    }

    .stat-item {
        padding: 20px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
    }

    .stat-icon i {
        font-size: 20px;
    }

    .stat-item h3 {
        font-size: 2rem;
    }

    .benefit-item {
        padding: 20px;
        margin-bottom: 20px;
    }

    .btn-lg {
        padding: 12px 25px;
        font-size: 1rem;
    }
}
</style>

<script>
function toggleFeatureDescription(element) {
    // Remove active class from all other features
    const allFeatures = document.querySelectorAll('.feature-item');
    allFeatures.forEach(item => {
        if(item !== element) {
            item.classList.remove('active');
        }
    });
    
    // Toggle active class on clicked feature
    element.classList.toggle('active');
}
</script>

<!-- Services Section -->
<section class="services-section py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach($services as $key => $service): ?>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
                <div class="service-card h-100 d-flex flex-column">
                    <div class="service-image">
                        <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['title']; ?>">
                        <div class="service-overlay">
                            <i class="<?php echo $service['icon']; ?>"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="service-icon">
                            <i class="<?php echo $service['icon']; ?>"></i>
                        </div>
                        <h3 class="h4 mb-3"><?php echo $service['title']; ?></h3>
                        <p class="mb-4"><?php echo $service['description']; ?></p>
                        <div class="features-list flex-grow-1">
                            <?php 
                            $features = json_decode($service['features'], true);
                            $descriptions = [
                                'Network Design' => 'Perancangan arsitektur jaringan yang aman dan efisien sesuai kebutuhan bisnis Anda',
                                'Implementation' => 'Implementasi sistem keamanan dengan standar industri terkini',
                                'Security Configuration' => 'Konfigurasi keamanan menyeluruh untuk melindungi aset digital Anda',
                                'Performance Optimization' => 'Optimasi performa untuk kecepatan dan efisiensi maksimal',
                                'Performance Analysis' => 'Analisis mendalam terhadap kinerja jaringan Anda',
                                'Network Optimization' => 'Optimasi jaringan untuk performa terbaik',
                                'Traffic Management' => 'Manajemen lalu lintas data yang efisien',
                                'Bandwidth Control' => 'Kontrol bandwidth untuk penggunaan optimal',
                                '24/7 Monitoring' => 'Pemantauan sistem non-stop sepanjang waktu',
                                'Real-time Alerts' => 'Notifikasi real-time untuk setiap ancaman',
                                'Performance Analytics' => 'Analitik performa detail untuk pengambilan keputusan',
                                'Issue Detection' => 'Deteksi dini masalah keamanan',
                                'Penetration Testing' => 'Pengujian keamanan menyeluruh untuk menemukan celah',
                                'Vulnerability Assessment' => 'Penilaian kerentanan sistem secara komprehensif',
                                'Security Audit' => 'Audit keamanan mendalam sesuai standar industri',
                                'Risk Analysis' => 'Analisis risiko untuk pencegahan ancaman',
                                'Incident Investigation' => 'Investigasi mendalam untuk setiap insiden keamanan',
                                'Evidence Collection' => 'Pengumpulan bukti digital secara forensik',
                                'Data Recovery' => 'Pemulihan data dengan tingkat keberhasilan tinggi',
                                'Analysis Report' => 'Laporan analisis detail untuk setiap investigasi',
                                'Data Encryption' => 'Enkripsi data end-to-end untuk keamanan maksimal',
                                'Key Management' => 'Manajemen kunci enkripsi yang aman',
                                'Secure Storage' => 'Penyimpanan data dengan enkripsi tingkat tinggi',
                                'Access Control' => 'Kontrol akses berlapis untuk keamanan optimal'
                            ];
                            foreach($features as $feature): 
                            ?>
                            <div class="feature-item" onclick="toggleFeatureDescription(this)">
                                <div class="feature-main">
                                    <div class="feature-icon-wrapper">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="feature-content">
                                        <span class="feature-title"><?php echo $feature; ?></span>
                                        <div class="feature-controls">
                                            <span class="feature-badge">Klik untuk detail</span>
                                            <i class="fas fa-chevron-right feature-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="feature-description">
                                    <div class="description-content">
                                        <i class="fas fa-arrow-left back-arrow"></i>
                                        <div>
                                            <h6 class="description-title"><?php echo $feature; ?></h6>
                                            <p><?php echo $descriptions[$feature] ?? 'Deskripsi fitur akan segera hadir'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="service-footer mt-auto">
                            <div class="price-tag">
                                <span class="price">Rp <?php echo number_format($service['price'], 0, ',', '.'); ?></span>
                                <span class="duration"><?php echo $service['duration']; ?></span>
                            </div>
                            <div class="cta-buttons d-flex justify-content-center">
                                <a href="contact.php" class="btn btn-primary btn-lg btn-animated">
                                    <i class="fas fa-phone-alt me-2"></i>Konsultasi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Tambahkan section CTA setelah Services Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-wrapper text-center p-5 scroll-fade">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="gradient-text mb-4">Lindungi Aset Digital Anda Sekarang</h2>
                    <p class="lead mb-4">Jangan biarkan ancaman cyber menghambat pertumbuhan bisnis Anda. Tim ahli kami siap membantu mengamankan infrastruktur digital Anda dengan solusi keamanan terdepan.</p>
                    
                    <!-- Animated Stats -->
                    <div class="stats-container mb-5">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="stat-item floating">
                                    <div class="stat-icon">
                                        <i class="fas fa-shield-alt icon-pulse"></i>
                                    </div>
                                    <h3 class="counter" data-target="100">0</h3>
                                    <p>Klien Terpuaskan</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item floating" style="animation-delay: 0.2s">
                                    <div class="stat-icon">
                                        <i class="fas fa-user-shield icon-pulse"></i>
                                    </div>
                                    <h3 class="counter" data-target="50">0</h3>
                                    <p>Tim Ahli</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-item floating" style="animation-delay: 0.4s">
                                    <div class="stat-icon">
                                        <i class="fas fa-chart-line icon-pulse"></i>
                                    </div>
                                    <h3 class="counter" data-target="95">0</h3>
                                    <p>Tingkat Keberhasilan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="benefits-container mb-5">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="benefit-item card-animated">
                                    <i class="fas fa-clock"></i>
                                    <h5>Monitoring 24/7</h5>
                                    <p>Pemantauan sistem keamanan non-stop</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="benefit-item card-animated">
                                    <i class="fas fa-certificate"></i>
                                    <h5>Tim Tersertifikasi</h5>
                                    <p>Ahli keamanan berpengalaman</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="benefit-item card-animated">
                                    <i class="fas fa-headset"></i>
                                    <h5>Support 24 Jam</h5>
                                    <p>Bantuan teknis kapan saja</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="cta-buttons">
                        <a href="contact.php" class="btn btn-primary btn-lg btn-animated me-3">
                            <i class="fas fa-phone-alt me-2"></i>Konsultasi Gratis
                        </a>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* CTA Section Styles */
.cta-section {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(16, 185, 129, 0.05));
    position: relative;
    overflow: hidden;
}

.cta-wrapper {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.cta-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

/* Stats Styles */
.stat-item {
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stat-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    font-size: 24px;
    color: white;
}

.stat-item h3 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 5px;
}

/* Benefits Styles */
.benefit-item {
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.benefit-item i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 15px;
}

.benefit-item:hover {
    transform: translateY(-10px);
}

/* Counter Animation */
@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.counter {
    animation: countUp 1s ease-out forwards;
}

/* Dark Mode Adjustments */
.dark-mode .cta-wrapper {
    background: #2D3748;
}

.dark-mode .stat-item,
.dark-mode .benefit-item {
    background: rgba(45, 55, 72, 0.9);
    color: white;
}

.dark-mode .benefit-item i {
    color: var(--secondary-color);
}
</style>

<script>
// Counter Animation
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000; // 2 seconds
    const step = target / (duration / 16); // 60fps
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Start counter animation when element is in view
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.counter');
            counters.forEach(counter => animateCounter(counter));
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stats-container').forEach(container => {
    observer.observe(container);
});
</script>

<?php include 'footer.php'; ?>
