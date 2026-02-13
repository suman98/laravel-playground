<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | Portfolio</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Animated Background Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.15;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, #6366f1 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-100px) translateX(50px); }
            50% { transform: translateY(-200px) translateX(-50px); }
            75% { transform: translateY(-100px) translateX(100px); }
        }

        /* Navbar */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            font-weight: 500;
            color: #cbd5e1 !important;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #6366f1 !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            position: relative;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease;
        }

        .hero .lead {
            font-size: 1.5rem;
            color: #94a3b8;
            animation: fadeInUp 1.2s ease;
        }

        .hero .emoji {
            display: inline-block;
            animation: wave 2s infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Buttons */
        .btn-custom {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.5);
        }

        /* Section Styling */
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 60px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #a855f7);
            border-radius: 2px;
        }

        /* About Section */
        #about {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 80px 20px;
            margin: 40px 0;
        }

        #about p {
            font-size: 1.2rem;
            line-height: 2;
            color: #cbd5e1;
        }

        /* Projects Section */
        .card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.3);
            border-color: rgba(99, 102, 241, 0.5);
        }

        .card h5 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
        }

        .card p {
            color: #94a3b8;
            line-height: 1.8;
        }

        .card .icon {
            font-size: 2.5rem;
            color: #6366f1;
            margin-bottom: 20px;
        }

        /* Contact Section */
        #contact {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 80px 20px;
        }

        .contact-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.2rem;
            margin: 15px 0;
            color: #cbd5e1;
        }

        .contact-info i {
            color: #6366f1;
            font-size: 1.5rem;
        }

        .social-links {
            margin-top: 30px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(99, 102, 241, 0.1);
            border: 2px solid rgba(99, 102, 241, 0.3);
            border-radius: 50%;
            color: #6366f1;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }

        /* Footer */
        footer {
            background: rgba(2, 6, 23, 0.8);
            padding: 30px 0;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(99, 102, 241, 0.2);
        }

        footer small {
            color: #64748b;
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero .lead {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

<!-- Animated Background -->
<div class="particles">
    <div class="particle" style="width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="width: 150px; height: 150px; top: 60%; left: 80%; animation-delay: 2s;"></div>
    <div class="particle" style="width: 80px; height: 80px; top: 40%; left: 50%; animation-delay: 4s;"></div>
    <div class="particle" style="width: 120px; height: 120px; top: 80%; left: 20%; animation-delay: 6s;"></div>
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Suman Thapa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#projects" class="nav-link">Projects</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Hi, I'm Suman <span class="emoji">👋</span></h1>
        <p class="lead mt-4">Full Stack Developer | Laravel | Vue | React | DevOps</p>
        <a href="#projects" class="btn btn-custom text-white mt-4">
            <i class="fas fa-rocket me-2"></i>View My Work
        </a>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="container fade-in">
    <div class="text-center">
        <h2 class="section-title">About Me</h2>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <p>
                    I am a passionate full-stack developer specializing in <strong>Laravel</strong>,
                    <strong>Vue.js</strong>, <strong>React</strong>, and server infrastructure. 
                    I love building scalable applications and solving complex performance issues.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- PROJECTS -->
<section id="projects" class="py-5">
    <div class="container">
        <h2 class="text-center section-title">Projects</h2>

        <div class="row g-4">

            <div class="col-md-4 fade-in">
                <div class="card p-4">
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5>Live Market App</h5>
                    <p>Real-time stock market dashboard with filtering and WebSocket support.</p>
                    <a href="#" class="btn btn-custom text-white btn-sm mt-3">
                        View Project <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 fade-in">
                <div class="card p-4">
                    <div class="icon">
                        <i class="fas fa-analytics"></i>
                    </div>
                    <h5>Laravel Analytics System</h5>
                    <p>Data visualization dashboard with optimized queries and caching.</p>
                    <a href="#" class="btn btn-custom text-white btn-sm mt-3">
                        View Project <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 fade-in">
                <div class="card p-4">
                    <div class="icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h5>React Native App</h5>
                    <p>Cross-platform mobile app with notification system and AsyncStorage.</p>
                    <a href="#" class="btn btn-custom text-white btn-sm mt-3">
                        View Project <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="container fade-in">
    <div class="text-center">
        <h2 class="section-title">Contact Me</h2>
        
        <div class="contact-info">
            <i class="fas fa-envelope"></i>
            <span>talktosumanthapa@gmail.com</span>
        </div>
        
        <div class="contact-info">
            <i class="fab fa-github"></i>
            <span>github.com/suman98</span>
        </div>

        <div class="social-links">
            <a href="https://github.com/suman98" target="_blank"><i class="fab fa-github"></i></a>
            <a href="https://www.linkedin.com/in/suman-thapa-3a957a1b5/" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://twitter.com/yourhandle" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="talktosumanthapa@gmail.com"><i class="fas fa-envelope"></i></a>
        </div>

        <a href="mailto:your@email.com" class="btn btn-custom text-white mt-4">
            <i class="fas fa-paper-plane me-2"></i>Send Email
        </a>
    </div>
</section>

<footer class="text-center mt-5">
    <div class="container">
        <small>© {{ date('Y') }} Suman Thapa. All rights reserved. Built with <i class="fas fa-heart" style="color: #ef4444;"></i></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Scroll Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    });

    document.querySelectorAll('.fade-in').forEach((el) => observer.observe(el));

    // Navbar Scroll Effect
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>

</body>
</html>
