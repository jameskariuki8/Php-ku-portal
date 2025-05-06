<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>KU Student Portal System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
        @endif

        <!-- Custom Styles -->
        <style>
            /* Global Body Styling */
            body {
                background: linear-gradient(135deg, #4e73df, #1d72b8);
                color: white;
                font-family: 'Instrument Sans', sans-serif;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 0;
                margin: 0;
                overflow-x: hidden;
            }

            /* Navbar Styling */
            .navbar {
                width: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(10px);
                padding: 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 9999;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .navbar .message {
                font-size: 1.2rem;
                color: #ffcb2b;
                font-weight: 600;
                white-space: nowrap;
                animation: scrollMessage 15s linear infinite;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

            @keyframes scrollMessage {
                0% {
                    transform: translateX(100%);
                }
                100% {
                    transform: translateX(-100%);
                }
            }

            /* Carousel Container */
            .carousel-container {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: -1;
                overflow: hidden;
            }

            /* Carousel Images */
            .carousel-images {
                display: flex;
                width: 500%;
                height: 100vh;
                animation: slide 30s infinite ease-in-out;
            }

            .carousel-images img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: brightness(0.6);
                transition: filter 0.5s ease;
            }

            /* Sliding Animation */
            @keyframes slide {
                0%, 18% {
                    transform: translateX(0);
                }
                20%, 38% {
                    transform: translateX(-20%);
                }
                40%, 58% {
                    transform: translateX(-40%);
                }
                60%, 78% {
                    transform: translateX(-60%);
                }
                80%, 98% {
                    transform: translateX(-80%);
                }
                100% {
                    transform: translateX(-100%);
                }
            }

            /* Main Content Container */
            .main-content {
                max-width: 1200px;
                width: 90%;
                margin: 0 auto;
                padding: 6rem 2rem 2rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                z-index: 1;
            }

            /* Welcome Message Styling */
            .welcome-container {
                text-align: center;
                margin-bottom: 3rem;
                width: 100%;
                max-width: 800px;
            }

            .welcome-card {
                background: rgba(165, 42, 42, 0.85);
                backdrop-filter: blur(5px);
                color: white;
                padding: 2rem;
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.1);
                margin-bottom: 1.5rem;
                transition: all 0.3s ease;
            }

            .welcome-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            }

            .welcome-title {
                font-size: 3rem;
                font-weight: 800;
                margin-bottom: 1rem;
                background: linear-gradient(to right, #ffffff, #ffcb2b);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .welcome-subtitle {
                font-size: 1.5rem;
                font-weight: 500;
                line-height: 1.6;
                opacity: 0.9;
            }

            /* Button Styling */
            .btn {
                padding: 14px 28px;
                font-size: 1rem;
                font-weight: 600;
                text-transform: uppercase;
                border-radius: 12px;
                transition: all 0.3s ease;
                letter-spacing: 0.5px;
                position: relative;
                overflow: hidden;
                border: none;
                cursor: pointer;
                min-width: 180px;
                text-align: center;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: 0.5s;
            }

            .btn:hover::before {
                left: 100%;
            }

            .btn-login {
                background: linear-gradient(135deg, #1d72b8, #4e73df);
                color: white;
                box-shadow: 0 4px 15px rgba(29, 114, 184, 0.4);
            }

            .btn-register {
                background: linear-gradient(135deg, #ff8c00, #ff6b00);
                color: white;
                box-shadow: 0 4px 15px rgba(255, 140, 0, 0.4);
            }

            .btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            }

            .btn:active {
                transform: translateY(1px);
            }

            .btn-container {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                margin-top: 2rem;
                flex-wrap: wrap;
            }

            /* Animations */
            .fade-in {
                animation: fadeIn 1s ease-out forwards;
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .pulse {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
                100% {
                    transform: scale(1);
                }
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .welcome-title {
                    font-size: 2rem;
                }
                
                .welcome-subtitle {
                    font-size: 1.2rem;
                }
                
                .btn-container {
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .btn {
                    width: 100%;
                }
                
                .navbar .message {
                    font-size: 1rem;
                }
            }

            /* Floating Particles */
            .particles {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                pointer-events: none;
            }

            .particle {
                position: absolute;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                animation: float linear infinite;
            }

            @keyframes float {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        </style>
    </head>
    <body class="text-white flex items-center justify-center min-h-screen fade-in">

        <!-- Floating Particles -->
        <div class="particles" id="particles"></div>

        <!-- Navbar with Moving Message -->
        <div class="navbar animate__animated animate__fadeInDown">
            <div class="message">Welcome to KU Student Portal System • Manage your academic journey • Stay connected with campus life</div>
        </div>

        <!-- Carousel Background -->
        <div class="carousel-container">
            <div class="carousel-images">
                <img src="{{ asset('images/p1.jpg') }}" alt="University Campus" class="animate__animated animate__fadeIn">
                <img src="{{ asset('images/p2.jpg') }}" alt="Students Studying">
                <img src="{{ asset('images/p3.jpg') }}" alt="Library">
                <img src="{{ asset('images/p4.jpg') }}" alt="Graduation">
                <img src="{{ asset('images/p5.jpg') }}" alt="Classroom">
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Welcome Message Section -->
            <div class="welcome-container animate__animated animate__fadeIn animate__delay-1s">
                <div class="welcome-card pulse">
                    <h1 class="welcome-title">Welcome to KU Student Portal</h1>
                </div>
                <div class="welcome-card animate__animated animate__fadeIn animate__delay-2s">
                    <p class="welcome-subtitle">
                        Your gateway to academic resources, course management, and campus connectivity. 
                        Whether you're a student, faculty member, or administrator, we've got you covered.
                    </p>
                </div>
            </div>

            <!-- Authentication Section -->
            <header class="w-full max-w-4xl animate__animated animate__fadeIn animate__delay-3s">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-center gap-4">
                        @auth
                            <!-- Dashboard button removed -->
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-register">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>
        </div>

        <script>
            // Create floating particles
            document.addEventListener('DOMContentLoaded', function() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = 30;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    // Random size between 2px and 6px
                    const size = Math.random() * 4 + 2;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    
                    // Random position
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.top = `${Math.random() * 100}%`;
                    
                    // Random animation duration between 10s and 20s
                    const duration = Math.random() * 10 + 10;
                    particle.style.animationDuration = `${duration}s`;
                    
                    // Random delay
                    particle.style.animationDelay = `${Math.random() * 5}s`;
                    
                    particlesContainer.appendChild(particle);
                }
                
                // Add hover effect to carousel images
                const carouselImages = document.querySelectorAll('.carousel-images img');
                carouselImages.forEach(img => {
                    img.addEventListener('mouseenter', () => {
                        img.style.filter = 'brightness(0.8)';
                    });
                    img.addEventListener('mouseleave', () => {
                        img.style.filter = 'brightness(0.6)';
                    });
                });
            });
        </script>
    </body>
</html>