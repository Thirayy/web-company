<?php include 'header.php'; ?>

<div class="container py-5">
    <!-- Hero Section -->
    <div class="row" style="margin-top: 100px;">
        <div class="col-lg-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-gradient mb-4">Tentang CyberOnly</h1>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6" data-aos="fade-right">
            <div class="about-image-wrapper">
                <img src="assets/New folder/workteam.jpg" alt="Tim Keamanan Kami" class="about-image">
                <div class="experience-badge">
                    <span class="number">10+</span>
                    <span class="text">Tahun Pengalaman</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="content-wrapper">
                <h2 class="mb-4">Solusi Keamanan Jaringan Terpercaya</h2>
                <p class="lead">Kami adalah tim ahli keamanan jaringan yang berkomitmen untuk melindungi infrastruktur digital Anda dengan solusi keamanan yang komprehensif dan inovatif.</p>
                <p>Dengan pengalaman lebih dari 10 tahun dalam industri keamanan siber, kami telah membantu ratusan perusahaan dalam mengamankan aset digital mereka dari berbagai ancaman siber.</p>
            </div>
        </div>
    </div>

    <!-- Services Overview -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="services-grid">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="service-item" data-aos="fade-up">
                            <div class="icon-box">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="h5">Perlindungan Jaringan</h3>
                            <p>Sistem keamanan jaringan 24/7 dengan monitoring real-time dan respons cepat terhadap ancaman.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="service-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h3 class="h5">Enkripsi Data</h3>
                            <p>Teknologi enkripsi tingkat lanjut untuk melindungi data sensitif perusahaan Anda.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="service-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 class="h5">Konsultasi Keamanan</h3>
                            <p>Tim ahli kami siap memberikan konsultasi dan solusi keamanan yang disesuaikan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="features-grid">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="feature-item" data-aos="fade-up">
                            <i class="fas fa-certificate"></i>
                            <h4>Bersertifikasi</h4>
                            <p>Tim ahli tersertifikasi internasional</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                            <i class="fas fa-clock"></i>
                            <h4>24/7 Support</h4>
                            <p>Dukungan teknis setiap saat</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                            <i class="fas fa-sync"></i>
                            <h4>Update Berkala</h4>
                            <p>Pembaruan sistem keamanan rutin</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                            <i class="fas fa-hand-holding-usd"></i>
                            <h4>Harga Kompetitif</h4>
                            <p>Solusi terbaik dengan harga terjangkau</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Styling */
.text-gradient {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.about-image-wrapper {
    position: relative;
    padding: 20px;
}

.about-image {
    width: 100%;
    max-width: 500px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.experience-badge {
    position: absolute;
    bottom: 40px;
    right: 40px;
    background: var(--primary-color);
    color: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.experience-badge .number {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
    line-height: 1;
}

.service-item {
    padding: 30px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
}

.service-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.icon-box {
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    color: white;
    font-size: 24px;
    transform: rotate(-10deg);
    transition: all 0.3s ease;
}

.service-item:hover .icon-box {
    transform: rotate(0deg) scale(1.1);
}

.feature-item {
    text-align: center;
    padding: 30px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.feature-item i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 15px;
}

/* Dark Mode Adjustments */
.dark-mode .service-item,
.dark-mode .feature-item {
    background: #2D3748;
    color: white;
}

.dark-mode .service-item p,
.dark-mode .feature-item p {
    color: #CBD5E0;
}

@media (max-width: 768px) {
    .about-image {
        max-width: 100%;
    }
    
    .experience-badge {
        bottom: 20px;
        right: 20px;
        padding: 15px;
    }
}
</style>

<?php include 'footer.php'; ?>