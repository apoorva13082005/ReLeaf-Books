<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'seller'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-book-open"></i>Re<span>Leaf</span> Book</a>
        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="profile-circle"><?= strtoupper(substr($_SESSION['name'], 0, 1)); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li class="dropdown-item fw-bold"><?= htmlspecialchars($_SESSION['name']); ?></li>
                <li class="dropdown-item text-muted">ID: <?= htmlspecialchars($_SESSION['user_id']); ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReLeaf Book - Sustainable Book Exchange</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>   

        :root {
            --primary: #2e8b57;
            --primary-light: #3cb371;
            --primary-dark: #1d6e42;
            --secondary: #8a5a44;
            --accent: #ff6b35;
            --light: #f8f9fa;
            --dark: #343a40;
            --light-bg: #f9f6f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
           background: linear-gradient(135deg, #f6f7fb 0%, #eafaf1 100%);
            line-height: 1.6;
            min-height: 100vh;
    display: flex;
    flex-direction: column;
     overflow-x: hidden;
            
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        .dashboard-card {
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(60,180,75,0.08);
            transition: box-shadow 0.2s, transform 0.2s;
            background: #fff;
        }
        .dashboard-card:hover {
            box-shadow: 0 8px 32px rgba(60,180,75,0.18);
            transform: translateY(-4px) scale(1.03);
        }
      .sidebar {
        width: 250px;
    position: fixed;
    left: 0;
    top: 70px; /* Below navbar */
    height: calc(100vh - 70px);
    overflow-y: auto;
    z-index: 1000;
    background: #fff;
    border-right: 1px solid #eee;    
    
    
    min-height: calc(100vh - 70px);
}
        .main-content {
            flex: 1;
    /* Same as sidebar width */
    padding: 20px;
    margin-top: 70px; /* Height of navbar */
    width: calc(100% - 250px);
    min-height: calc(100vh - 70px);
    background: linear-gradient(135deg, #f6f7fb 0%, #eafaf1 100%);
            
            margin-left: 220px;
            
        }
        .profile-circle {
            width: 48px;
            height: 48px;
            background: #198754;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        
        .navbar {
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            height: 70px;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 28px;
            color: var(--primary);
            display: flex;
            align-items: center;
        }
        
        .navbar-brand span {
            color: var(--secondary);
        }
        
        .navbar-brand i {
            margin-right: 8px;
            color: var(--accent);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 12px;
            position: relative;
            padding: 8px 0 !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            padding: 12px 28px;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46, 139, 87, 0.4);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border: 2px solid var(--primary);
            background: transparent;
            padding: 10px 26px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46, 139, 87, 0.3);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3') center/cover no-repeat;
            padding: 120px 0 100px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(249,246,241,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 24px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .search-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 5px;
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .search-input {
            background: transparent;
            border: none;
            color: white;
            padding: 15px 20px;
            width: 100%;
        }
        
        .search-input:focus {
            outline: none;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .search-btn {
            background: var(--accent);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            background: #ff884d;
            transform: translateY(-2px);
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 15px auto;
            border-radius: 2px;
        }
        
        .feature-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(46, 139, 87, 0.1) 0%, rgba(60, 179, 113, 0.1) 100%);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
        }
        
        .category-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .category-card img {
            transition: transform 0.5s ease;
        }
        
        .category-card:hover img {
            transform: scale(1.05);
        }
        
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
            padding: 30px 20px 20px;
            color: white;
        }
        
        .eco-impact {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .eco-impact:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 C50,100 50,0 100,100 L100,0 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .eco-stat {
            text-align: center;
            padding: 30px 20px;
            position: relative;
            z-index: 2;
        }
        
        .eco-stat i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .eco-stat h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin: 15px 0;
            position: relative;
        }
        
        .testimonial-card:after {
            content: '"';
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 5rem;
            font-family: 'Playfair Display', serif;
            color: rgba(46, 139, 87, 0.1);
            line-height: 1;
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid var(--primary);
        }
        .card {
    border-radius: 1rem;
    transition: box-shadow 0.2s;
}
.card:hover {
    box-shadow: 0 8px 32px rgba(60, 180, 75, 0.15);
}
        footer {
            margin-top: auto;
            background: linear-gradient(135deg, var(--dark) 0%, #2c3e50 100%);
            color: white;
            padding: 80px 0 30px;
            position: relative;
            flex-shrink: 0;
        }
        
        .footer-heading {
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--accent);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-icons {
            margin-top: 25px;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .book-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .book-thumb {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .book-card:hover .book-thumb {
            transform: scale(1.05);
        }
        
        .badge-verified {
            background: linear-gradient(135deg, #17a2b8 0%, #1bc9e4 100%);
            color: white;
        }
        
        .badge-discount {
            background: linear-gradient(135deg, var(--accent) 0%, #ff884d 100%);
            color: white;
        }
        
        .group-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
        }
        
        .group-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--secondary) 0%, #a87c65 100%);
            color: white;
            padding: 80px 0;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        
        .cta-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 C50,100 50,0 100,100 L100,0 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .floating-icon {
            position: absolute;
            font-size: 8rem;
            opacity: 0.1;
            z-index: 1;
        }
        
        .floating-icon-1 {
            top: 20%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-icon-2 {
            bottom: 20%;
            right: 10%;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .search-box {
                flex-direction: column;
                background: transparent;
            }
            
            .search-input {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border-radius: 50px;
                margin-bottom: 10px;
                text-align: center;
            }
            
            .floating-icon {
                display: none;
            }
        }
    </style>
    </head>
<body>

    <?php else: ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReLeaf Book - Sustainable Book Exchange</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
<style>
        :root {
            --primary: #2e8b57;
            --primary-light: #3cb371;
            --primary-dark: #1d6e42;
            --secondary: #8a5a44;
            --accent: #ff6b35;
            --light: #f8f9fa;
            --dark: #343a40;
            --light-bg: #f9f6f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
           background: linear-gradient(135deg, #f6f7fb 0%, #eafaf1 100%);
            line-height: 1.6;
            min-height: 100vh;
    display: flex;
    flex-direction: column;
            
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        .dashboard-card {
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(60,180,75,0.08);
            transition: box-shadow 0.2s, transform 0.2s;
            background: #fff;
        }
        .dashboard-card:hover {
            box-shadow: 0 8px 32px rgba(60,180,75,0.18);
            transform: translateY(-4px) scale(1.03);
        }
        .sidebar {
            min-width: 220px;
            max-width: 220px;
            background: #fff;
            border-right: 1px solid #eee;
            min-height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            z-index: 100;
        }
        .main-content {
            margin-left: 220px;
            margin-top: 70px;
        }
        .profile-circle {
            width: 48px;
            height: 48px;
            background: #198754;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .navbar {
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            height: 70px;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 28px;
            color: var(--primary);
            display: flex;
            align-items: center;
        }
        
        .navbar-brand span {
            color: var(--secondary);
        }
        
        .navbar-brand i {
            margin-right: 8px;
            color: var(--accent);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 12px;
            position: relative;
            padding: 8px 0 !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            padding: 12px 28px;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46, 139, 87, 0.4);
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border: 2px solid var(--primary);
            background: transparent;
            padding: 10px 26px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46, 139, 87, 0.3);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3') center/cover no-repeat;
            padding: 120px 0 100px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(249,246,241,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 24px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .search-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 5px;
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .search-input {
            background: transparent;
            border: none;
            color: white;
            padding: 15px 20px;
            width: 100%;
        }
        
        .search-input:focus {
            outline: none;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .search-btn {
            background: var(--accent);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            background: #ff884d;
            transform: translateY(-2px);
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 15px auto;
            border-radius: 2px;
        }
        
        .feature-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 20px;
            background: linear-gradient(135deg, rgba(46, 139, 87, 0.1) 0%, rgba(60, 179, 113, 0.1) 100%);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
        }
        
        .category-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .category-card img {
            transition: transform 0.5s ease;
        }
        
        .category-card:hover img {
            transform: scale(1.05);
        }
        
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
            padding: 30px 20px 20px;
            color: white;
        }
        
        .eco-impact {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .eco-impact:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 C50,100 50,0 100,100 L100,0 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .eco-stat {
            text-align: center;
            padding: 30px 20px;
            position: relative;
            z-index: 2;
        }
        
        .eco-stat i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .eco-stat h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin: 15px 0;
            position: relative;
        }
        
        .testimonial-card:after {
            content: '"';
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 5rem;
            font-family: 'Playfair Display', serif;
            color: rgba(46, 139, 87, 0.1);
            line-height: 1;
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid var(--primary);
        }
        .card {
    border-radius: 1rem;
    transition: box-shadow 0.2s;
}
.card:hover {
    box-shadow: 0 8px 32px rgba(60, 180, 75, 0.15);
}
        footer {
            margin-top: auto;
            background: linear-gradient(135deg, var(--dark) 0%, #2c3e50 100%);
            color: white;
            padding: 80px 0 30px;
            position: relative;
        }
        
        .footer-heading {
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--accent);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-icons {
            margin-top: 25px;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .book-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
        }
        
        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .book-thumb {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .book-card:hover .book-thumb {
            transform: scale(1.05);
        }
        
        .badge-verified {
            background: linear-gradient(135deg, #17a2b8 0%, #1bc9e4 100%);
            color: white;
        }
        
        .badge-discount {
            background: linear-gradient(135deg, var(--accent) 0%, #ff884d 100%);
            color: white;
        }
        
        .group-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
        }
        
        .group-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--secondary) 0%, #a87c65 100%);
            color: white;
            padding: 80px 0;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        
        .cta-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 C50,100 50,0 100,100 L100,0 Z" fill="rgba(255,255,255,0.05)"/></svg>');
            background-size: 100% 100%;
        }
        
        .floating-icon {
            position: absolute;
            font-size: 8rem;
            opacity: 0.1;
            z-index: 1;
        }
        
        .floating-icon-1 {
            top: 20%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-icon-2 {
            bottom: 20%;
            right: 10%;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .search-box {
                flex-direction: column;
                background: transparent;
            }
            
            .search-input {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border-radius: 50px;
                margin-bottom: 10px;
                text-align: center;
            }
            
            .floating-icon {
                display: none;
            }
        }
    </style>
    </head>
<body>

    <header>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#"><i class="fas fa-book-open"></i>Re<span>Leaf</span> Book</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Books">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Groups">Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Syllabus Match</a>
                    </li>
                    
                </ul>
                <div class="d-flex">
                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-search"></i></a>
                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-heart"></i></a>
                    <div class="d-flex">
   
    <?php if (isset($_SESSION['name'])): ?>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width:40px; height:40px; font-size:1.2rem;">
                    <?= strtoupper(substr($_SESSION['name'], 0, 1)); ?>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li class="dropdown-item fw-bold"><?= htmlspecialchars($_SESSION['name']); ?></li>
                <li class="dropdown-item text-muted">ID: <?= htmlspecialchars($_SESSION['user_id']); ?></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary"><i class="fas fa-user me-2"></i>Login</a>
    <?php endif; ?>
</div>
                </div>
            </div>
        </div>
    </nav>
</header>
<?php endif; ?>
   