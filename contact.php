<?php include 'header.php'; ?>

<!-- Hero Section -->
<div class="hero-contact position-relative">
    <div class="container">
        <div class="row min-vh-50 align-items-center py-5">
            <div class="col-lg-8 text-center mx-auto" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">Hubungi CyberOnly</h1>
                <p class="lead mb-4">Konsultasikan kebutuhan keamanan siber Anda dengan tim ahli kami</p>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Information -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="contact-info-card h-100">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Informasi Kontak</h3>
                        <div class="contact-item mb-4">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            <div class="ms-3">
                                <h4 class="h6 mb-1">Alamat</h4>
                                <p class="mb-0">Jl. Keamanan Cyber No. 123, Jakarta</p>
                            </div>
                        </div>
                        <div class="contact-item mb-4">
                            <i class="fas fa-phone fa-2x text-primary"></i>
                            <div class="ms-3">
                                <h4 class="h6 mb-1">Telepon</h4>
                                <p class="mb-0">+62 81384414563</p>
                            </div>
                        </div>
                        <div class="contact-item mb-4">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                            <div class="ms-3">
                                <h4 class="h6 mb-1">Email</h4>
                                <p class="mb-0">info@cyberonly.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                            <div class="ms-3">
                                <h4 class="h6 mb-1">Jam Operasional</h4>
                                <p class="mb-0">Senin - Jumat: 09:00 - 17:00</p>
                                <p class="mb-0">Sabtu: 09:00 - 14:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-form-card h-100">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Kirim Pesan</h3>
                        <form id="contactForm" method="POST" action="process/contact_process.php">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">No. WhatsApp</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label">Subjek</label>
                                        <select class="form-select" id="subject" name="subject" required>
                                            <option value="">Pilih Subjek</option>
                                            <option value="konsultasi">Konsultasi</option>
                                            <option value="layanan">Informasi Layanan</option>
                                            <option value="kerjasama">edukasi</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-label">Pesan</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="map-container rounded shadow-sm">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4444!2d106.8294!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNyJTIDEwNsKwNDknNDUuOSJF!5e0!3m2!1sen!2sid!4v1234567890"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
.hero-contact {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                url('assets/images/contact-bg.jpg') center/cover;
    padding: 120px 0 60px;
    color: white;
    margin-bottom: 30px;
}

.contact-info-card, .contact-form-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    background: white;
}

.contact-info-card:hover, .contact-form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.contact-item {
    display: flex;
    align-items: start;
}

.contact-item i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(79, 70, 229, 0.1);
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: 2px solid rgba(79, 70, 229, 0.1);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.map-container {
    overflow: hidden;
    border-radius: 15px;
}

/* Dark Mode Adjustments */
.dark-mode .contact-info-card,
.dark-mode .contact-form-card {
    background: #2D3748;
    color: white;
}

.dark-mode .form-control,
.dark-mode .form-select {
    background-color: #1A202C;
    border-color: rgba(255, 255, 255, 0.1);
    color: white;
}

.dark-mode .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.dark-mode .contact-item i {
    background: rgba(255, 255, 255, 0.1);
}

@media (max-width: 768px) {
    .contact-info-card, .contact-form-card {
        margin-bottom: 20px;
    }
}
</style>

<!-- Tambahkan script jQuery dan AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: './process/contact_process.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    alert(response.message);
                    $('#contactForm')[0].reset();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan sistem');
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>
