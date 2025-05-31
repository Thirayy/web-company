<?php
// Start session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data user jika sudah login
$user_data = null;
if(isset($_SESSION['user_id'])) {
    try {
        require_once __DIR__ . '/config/database.php';
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user_data = $stmt->fetch();
    } catch(PDOException $e) {
        error_log("Error fetching user data: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberOnly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animations.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom Color Variables */
        :root {
            --primary-color: #4F46E5;      /* Indigo */
            --secondary-color: #10B981;    /* Emerald */
            --accent-color: #F59E0B;       /* Amber */
            --dark-color: #1F2937;         /* Gray 800 */
            --light-color: #F3F4F6;        /* Gray 100 */
            --white-color: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #4F46E5 0%, #10B981 100%);
        }

        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: all 0.3s ease;
            background-color: var(--white-color);
            color: var(--dark-color);
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            margin-right: 1.5rem;
        }

        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(31, 41, 55, 0.8), rgba(31, 41, 55, 0.8)), 
                        url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--white-color);
            padding: 120px 0;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.3;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--white-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content {
            max-width: 600px;
            z-index: 1;
        }

        /* Cards and Sections */
        .card {
            border: none;
            border-radius: 15px;
            background: var(--white-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        /* Buttons */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: var(--dark-color);
            color: var(--light-color);
        }

        .dark-mode .navbar {
            background: rgba(31, 41, 55, 0.95);
        }

        .dark-mode .nav-link {
            color: var(--light-color) !important;
        }

        .dark-mode .card {
            background-color: #2D3748;
            color: var(--light-color);
        }

        .dark-mode .bg-light {
            background-color: #2D3748 !important;
        }

        .dark-mode .form-control {
            background-color: #4A5568;
            border-color: #4A5568;
            color: var(--light-color);
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: relative;
            width: 60px;
            height: 30px;
            margin: 0 15px;
        }

        .dark-mode-input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .dark-mode-label {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .dark-mode-label:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .dark-mode-input:checked + .dark-mode-label {
            background: var(--gradient-primary);
        }

        .dark-mode-input:checked + .dark-mode-label:before {
            transform: translateX(30px);
        }

        .dark-mode .navbar-brand {
            color: var(--white-color);
        }

        .dark-mode .hero h1 {
            background: linear-gradient(to right, var(--white-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dark-mode .service-card {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Animation Effects */
        [data-aos] {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        [data-aos].aos-animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Quiz Section Styling */
        .quiz-container {
            background: var(--white-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Table Styling */
        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--gradient-primary);
            color: var(--white-color);
            border: none;
        }

        /* Contact Form */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid var(--light-color);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        /* Gallery Styles */
        #gallery .card {
            transition: transform 0.3s ease;
        }
        
        #gallery .card:hover {
            transform: translateY(-10px);
        }
        
        #gallery .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        /* Update services card styles */
        .service-card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .service-card:hover {
            transform: translateY(-15px) scale(1.02);
        }

        .service-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .service-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .service-card .card-body {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.4s ease;
        }

        /* Dark mode updates */
        .dark-mode .service-card .card-body {
            background: rgba(45, 55, 72, 0.95);
        }

        /* Navbar Styling */
        .navbar-nav .nav-link {
            padding: 0.8rem 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link i {
            transition: transform 0.3s ease;
        }

        .navbar-nav .nav-link:hover i {
            transform: translateY(-2px);
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 1rem 0;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            display: block;
            pointer-events: none;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateX(5px);
        }

        /* Dark Mode Adjustments */
        .dark-mode .dropdown-menu {
            background: var(--dark-color);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .dark-mode .dropdown-item {
            color: var(--light-color);
        }

        .dark-mode .dropdown-item:hover {
            background: var(--gradient-primary);
            color: white;
        }

        /* Contact Button Styling */
        .nav-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: var(--gradient-primary);
            border: none;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }

        .dark-mode .nav-btn {
            background: var(--gradient-primary);
            color: var(--white-color);
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .nav-item.ms-lg-3 {
                margin-top: 1rem;
            }
            
            .nav-btn {
                width: 100%;
                text-align: center;
            }
        }

        /* Hero Section Button Styling */
        .hero .btn-primary,
        .hero .btn-outline-light {
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            min-width: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
        }

        .hero .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }

        .hero .btn-outline-light {
            border: 2px solid var(--white-color);
            color: var(--white-color);
        }

        .hero .btn-outline-light:hover {
            background: var(--white-color);
            color: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .hero .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        /* Responsive adjustments for hero buttons */
        @media (max-width: 768px) {
            .hero .btn-outline-light,
            .hero .btn-primary {
                padding: 4px 8px;
                font-size: 1rem;
                height: 35px;
                min-width: 130px;
            }
        }

        /* Footer Styling */
        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 20px 0;
        }

        footer a {
            color: var(--light-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        footer .list-inline-item {
            margin: 0 10px;
        }

        /* Contact Form Enhancements */
        .contact-info {
            background: var(--white-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-info h4 {
            margin-bottom: 15px;
        }

        .contact-info p {
            margin-bottom: 10px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        /* Dark Mode Adjustments */
        .dark-mode .contact-info {
            background: rgba(45, 55, 72, 0.95);
            color: var(--light-color);
        }

        .dark-mode footer {
            background-color: rgba(31, 41, 55, 0.95);
            color: var(--light-color);
        }

        .dark-mode footer a {
            color: var(--light-color);
        }

        .dark-mode footer a:hover {
            color: var(--accent-color);
        }

        /* About Section Enhancements */
        #about {
            background-color: var(--light-color);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            transform: skewY(-3deg);
        }

        #about > * {
            transform: skewY(3deg);
        }

        #about .container {
            transform: skewY(3deg);
        }

        #about .col-md-6 {
            background: var(--white-color);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15),
                        0 5px 15px rgba(16, 185, 129, 0.1);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        #about .col-md-6:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.2),
                        0 10px 20px rgba(16, 185, 129, 0.15);
        }

        #about h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
        }

        #about h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        #about p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark-color);
        }

        /* Dark Mode Adjustments for About Section */
        .dark-mode #about {
            background-color: var(--dark-color);
        }

        .dark-mode #about .col-md-6 {
            background: rgba(45, 55, 72, 0.95);
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.2),
                        0 5px 15px rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode #about h2,
        .dark-mode #about h3,
        .dark-mode #about p {
            color: var(--light-color);
        }

        .dark-mode .contact-info {
            background: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
            transition: all 0.3s ease;
        }

        .dark-mode .contact-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.2);
        }

        .dark-mode .contact-info h4 {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .dark-mode .contact-info h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        .dark-mode .contact-info p {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: var(--dark-color);
        }

        .dark-mode .contact-info i {
            width: 35px;
            height: 35px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1rem;
        }

        .dark-mode .contact-form {
            background: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
        }

        .dark-mode .form-control {
            background-color: rgba(45, 55, 72, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--light-color);
        }

        .dark-mode .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
        }

        /* Enhanced Contact Section with Better Dark/Light Mode Adaptation */
        .contact-section {
            background: var(--light-color);
            padding: 80px 0;
        }

        .contact-info {
            background: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.2);
        }

        .contact-info h4 {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .contact-info h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        .contact-info p {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: var(--dark-color);
        }

        .contact-info i {
            width: 35px;
            height: 35px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1rem;
        }

        .contact-form {
            background: var(--white-color);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.15);
        }

        .form-control {
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid rgba(79, 70, 229, 0.1);
            transition: all 0.3s ease;
            background-color: var(--white-color);
            color: var(--dark-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Dark Mode Adjustments */
        .dark-mode .contact-section {
            background: var(--dark-color);
        }

        .dark-mode .contact-info {
            background: rgba(45, 55, 72, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode .contact-info p {
            color: var(--light-color);
        }

        .dark-mode .contact-form {
            background: rgba(45, 55, 72, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode .form-control {
            background-color: rgba(45, 55, 72, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--light-color);
        }

        .dark-mode .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .dark-mode .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
        }

        .dark-mode .contact-info h4 {
            color: var(--light-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            #about {
                transform: skewY(-2deg);
            }

            #about > *,
            #about .container {
                transform: skewY(2deg);
            }

            .contact-info,
            .contact-form {
                margin-bottom: 30px;
            }
        }

        /* User Menu Styles */
        .user-menu {
            padding: 8px 15px !important;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background: rgba(79, 70, 229, 0.2);
            transform: translateY(-2px);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar i {
            font-size: 1.2rem;
            color: white;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark-color);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--primary-color);
            opacity: 0.8;
        }

        /* Dark Mode Adjustments */
        .dark-mode .user-menu {
            background: rgba(255, 255, 255, 0.1);
        }

        .dark-mode .user-menu:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .dark-mode .user-name {
            color: white;
        }

        .dark-mode .user-role {
            color: var(--secondary-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .user-menu {
                background: none !important;
                padding: 0.5rem 1rem !important;
            }
            
            .nav-item.dropdown {
                border-top: 1px solid rgba(0,0,0,0.1);
                margin-top: 10px;
                padding-top: 10px;
            }
            
            .dark-mode .nav-item.dropdown {
                border-top-color: rgba(255,255,255,0.1);
            }
        }
    </style>
    <script src="assets/js/animations.js" defer></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt me-2"></i>CyberOnly
            </a>
            <div class="d-flex align-items-center">
                <div class="dark-mode-toggle me-3">
                    <input type="checkbox" id="darkModeToggle" class="dark-mode-input">
                    <label for="darkModeToggle" class="dark-mode-label"></label>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">
                            <i class="fas fa-info-circle me-1"></i>Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">
                            <i class="fas fa-cogs me-1"></i>Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edukasi.php">
                            <i class="fas fa-graduation-cap me-1"></i>Edukasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">
                            <i class="fas fa-envelope me-1"></i>Kontak
                        </a>
                    </li>
                    
                    <?php if(isset($_SESSION['user_id']) && $user_data): ?>
                        <!-- User Account Dropdown -->
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle user-menu" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-info d-none d-lg-flex align-items-center">
                                    <div class="user-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="user-details ms-2">
                                        <span class="user-name"><?php echo htmlspecialchars($user_data['username']); ?></span>
                                        <span class="user-role"><?php echo ucfirst($user_data['role']); ?></span>
                                    </div>
                                </div>
                                <div class="d-lg-none">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                    <span class="ms-2"><?php echo htmlspecialchars($user_data['username']); ?></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if($user_data['role'] == 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item" href="admin/index.php">
                                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="fas fa-user me-2"></i>Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="my_courses.php">
                                        <i class="fas fa-graduation-cap me-2"></i>Kursus Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="change_password.php">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-primary nav-btn" href="login.php?redirect=<?php echo urlencode($_SERVER['PHP_SELF']); ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<style>
/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 15px;
    padding: 1rem 0;
}

.dropdown-item {
    padding: 0.7rem 1.5rem;
    color: var(--dark-color);
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: var(--light-color);
    padding-left: 2rem;
}

.dropdown-item i {
    width: 20px;
    text-align: center;
}

.dropdown-divider {
    margin: 0.5rem 0;
    opacity: 0.1;
}

/* User Icon Styles */
.nav-link .fa-user-circle {
    font-size: 1.5rem;
    color: var(--primary-color);
}

/* Dark Mode Adjustments */
.dark-mode .dropdown-menu {
    background: #2D3748;
    border: 1px solid rgba(255,255,255,0.1);
}

.dark-mode .dropdown-item {
    color: #CBD5E0;
}

.dark-mode .dropdown-item:hover {
    background: rgba(255,255,255,0.1);
}

.dark-mode .dropdown-divider {
    border-color: rgba(255,255,255,0.1);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dropdown-menu {
        margin-top: 10px;
    }
}
</style>

<script>
// Tambahkan script untuk menangani redirect setelah login
document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.querySelector('a[href^="login.php"]');
    if(loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = window.location.pathname;
            window.location.href = `login.php?redirect=${encodeURIComponent(currentPage)}`;
        });
    }
});
</script>