<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klampis Depo - Futuristic Building Materials</title>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-gray: #1a1a1a;
            --secondary-gray: #2c2c2c;
            --accent-green: #00ff80; /* Open status - bright green */
            --accent-red: #ff4757; /* Closed status */
            --text-light: #e0e0e0;
            --text-white: #ffffff;
            --border-color: #444444;
            --card-hover-bg: #383838;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-gray);
            color: var(--text-light);
            overflow-x: hidden; /* Prevent horizontal scroll from animations */
        }

        /* --- Custom Futuristic Styling --- */
        .futuristic-card {
            background-color: var(--secondary-gray);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .futuristic-card:hover {
            box-shadow: 0 8px 15px rgba(0, 255, 128, 0.1);
            transform: translateY(-3px);
            background-color: var(--card-hover-bg);
        }

        .futuristic-button {
            border: 2px solid var(--accent-green);
            background-color: transparent;
            color: var(--accent-green);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 8px;
        }

        .futuristic-button:hover {
            background-color: var(--accent-green);
            color: var(--primary-gray);
            transform: scale(1.05);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-gray) 0%, #0d0d0d 100%);
            padding: 8rem 0;
            position: relative;
            overflow: hidden;
            border-bottom: 2px solid var(--border-color);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            text-shadow: 0 0 15px rgba(0, 255, 128, 0.4);
        }

        .highlight-text {
            color: var(--accent-green);
        }

        .subtitle-accent {
            color: var(--text-white) !important;
            font-weight: 300;
            opacity: 0.9;
        }

        /* --- Animation: Pulsing Grid Background --- */
        .grid-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
            opacity: 0.1;
            animation: pulseGrid 20s infinite linear;
        }

        @keyframes pulseGrid {
            0% { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }

        /* --- Animation: Status Indicator --- */
        .status-indicator {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .status-open {
            background-color: var(--accent-green);
            box-shadow: 0 0 15px var(--accent-green);
            animation: pulse-open 1.5s infinite alternate;
        }

        .status-closed {
            background-color: var(--accent-red);
            box-shadow: 0 0 15px var(--accent-red);
            animation: pulse-closed 1.5s infinite alternate;
        }

        @keyframes pulse-open {
            from { opacity: 0.8; }
            to { opacity: 1; transform: scale(1.1); }
        }

        @keyframes pulse-closed {
            from { opacity: 0.6; }
            to { opacity: 0.9; transform: scale(1.05); }
        }

        /* --- Animation: Scroll Reveal Effect (for demonstration) --- */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- Product Image Placeholder Style --- */
        .product-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
            filter: grayscale(80%) brightness(80%);
            transition: filter 0.5s;
        }

        .futuristic-card:hover .product-image {
            filter: grayscale(0%) brightness(100%);
        }

        /* --- Footer Style --- */
        .footer-link:hover {
            color: var(--accent-green) !important;
            transform: scale(1.05);
        }

        /* --- Search Bar Style --- */
        .futuristic-search {
            background-color: var(--primary-gray);
            border: 1px solid var(--accent-green);
            color: var(--text-white);
            box-shadow: 0 0 10px rgba(0, 255, 128, 0.3);
            transition: all 0.3s;
        }

        .futuristic-search:focus {
            background-color: #0d0d0d;
            border-color: var(--accent-green);
            box-shadow: 0 0 15px var(--accent-green);
        }
    </style>
</head>
<body class="grid-bg">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top shadow-lg" style="border-bottom: 1px solid var(--border-color);">
        <div class="container py-2">
            <a class="navbar-brand hero-title highlight-text" href="#" style="font-size: 1.5rem;">KLAMPIS DEPO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <!-- Laravel Blade Login Link Placeholder -->
                        <a class="nav-link text-white futuristic-button btn-sm d-flex align-items-center" href="{{ route('login') }}" style="border-width: 1px; padding: 4px 12px;">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </a>
                        <!-- End Placeholder -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section text-center position-relative">
        <div class="container z-10">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="hero-title text-white mb-3 scroll-reveal">
                        BUILDING THE FUTURE. <span class="highlight-text">TODAY.</span>
                    </h1>
                    <!-- IMPROVED SUBTITLE TEXT AND COLOR -->
                    <p class="lead mb-5 subtitle-accent scroll-reveal" style="transition-delay: 0.1s; font-weight: 400;">
                        Engineering the future of construction. Your source for high-grade, modern materials in Surabaya. Innovation meets foundation at Klampis Depo.
                    </p>

                    <!-- Status Widget (Dynamic) -->
                    <div class="d-flex justify-content-center align-items-center mb-5 scroll-reveal" style="transition-delay: 0.2s;">
                        <span id="store-status-indicator" class="status-indicator"></span>
                        <span id="store-status-text" class="fw-bold text-uppercase">Checking Status...</span>
                    </div>

                    <a href="#products" class="btn btn-lg futuristic-button scroll-reveal" style="transition-delay: 0.3s;">
                        Explore Materials <i class="bi bi-arrow-down-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Product Search and Showcase Section -->
    <section id="products" class="py-5 py-md-5">
        <div class="container">
            <h2 class="text-center mb-4 text-white fw-bold scroll-reveal">MATERIAL INDEX <span class="highlight-text">- PRODUCTS</span></h2>
            <!-- SUBTITLE COLOR CHANGED TO ACCENT GREEN -->
            <p class="text-center mb-5 subtitle-accent scroll-reveal" style="transition-delay: 0.1s;">Browse our curated catalog of essential construction components.</p>

            <!-- Search Bar -->
            <div class="row justify-content-center mb-5 scroll-reveal" style="transition-delay: 0.2s;">
                <div class="col-lg-8">
                    <form method="GET" action="{{ route('welcome') }}">
                        <div class="input-group input-group-lg">
                            <input
                                type="text"
                                name="search"
                                class="form-control futuristic-search"
                                placeholder="Search for Cement, Steel, Sand, or Tiles..."
                                aria-label="Product Search"
                                value="{{ request('search') }}"
                            >
                            <button class="btn futuristic-button" type="submit" style="border-width: 1px; color: var(--text-light); border-color: var(--border-color);"
                                onmouseover="this.style.borderColor=getComputedStyle(document.documentElement).getPropertyValue('--accent-green');"
                                onmouseout="this.style.borderColor=getComputedStyle(document.documentElement).getPropertyValue('--border-color');">
                                <i class="bi bi-search"></i> Scan
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Product Grid - Dynamic Content Starts Here -->
            <div class="row g-4">
                @forelse ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 scroll-reveal" style="transition-delay: {{ 0.3 + (($loop->index % 4) * 0.1) }}s;">
                    <div class="futuristic-card p-3 h-100">
                        <!-- Placeholder Image (using product name as text) -->
                        <img src="https://placehold.co/600x400/3c3c3c/a0a0a0?text={{ urlencode($product->product_name) }}" class="product-image mb-3" alt="{{ $product->product_name }}">

                        <h5 class="text-white">{{ $product->product_name }}</h5>
                        <p class="text-muted small mb-3">Stock: {{ $product->stock }} units available.</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Format price as IDR -->
                            <p class="lead highlight-text mb-0 fw-bold">{{ 'IDR ' . number_format($product->sell_price, 0, ',', '.') }}</p>
                            <a href="https://www.tokopedia.com/klampisdepo" target="_blank" class="btn btn-sm futuristic-button">Buy Now</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="lead text-muted">No products currently available in the system or stock is zero.</p>
                </div>
                @endforelse
            </div>
            <!-- Dynamic Content Ends Here -->

            <div class="text-center mt-5 scroll-reveal" style="transition-delay: 0.7s;">
                 <a href="https://www.tokopedia.com/klampisdepo" target="_blank" class="btn btn-lg futuristic-button w-50">
                    <i class="bi bi-shop me-2"></i> View All 1000+ Items on Tokopedia
                </a>
            </div>
        </div>
    </section>

    <!-- Service & Value Proposition Section -->
    <section id="services" class="py-5 bg-black" style="border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <h2 class="text-center mb-5 text-white fw-bold scroll-reveal">ADVANCED LOGISTICS <span class="highlight-text">- EFFICIENCY</span></h2>

            <div class="row g-4 text-center">
                <!-- Feature 1 -->
                <div class="col-md-4 scroll-reveal" style="transition-delay: 0.1s;">
                    <div class="futuristic-card p-4 h-100">
                        <i class="bi bi-truck-flatbed text-white mb-3" style="font-size: 3rem; color: var(--accent-green) !important;"></i>
                        <h4 class="text-white">Rapid Deployment</h4>
                        <p class="text-grey">Guaranteed delivery within the Surabaya radius. Materials on-site when you need them, not days later.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-4 scroll-reveal" style="transition-delay: 0.2s;">
                    <div class="futuristic-card p-4 h-100">
                        <i class="bi bi-shield-check text-white mb-3" style="font-size: 3rem; color: var(--accent-green) !important;"></i>
                        <h4 class="text-white">Certified Quality</h4>
                        <p class="text-grey">Every product is sourced from certified suppliers and undergoes rigorous quality assurance protocols.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-4 scroll-reveal" style="transition-delay: 0.3s;">
                    <div class="futuristic-card p-4 h-100">
                        <i class="bi bi-cpu text-white mb-3" style="font-size: 3rem; color: var(--accent-green) !important;"></i>
                        <h4 class="text-white">Project Consultation</h4>
                        <p class="text-grey">Leverage our decades of experience. Get expert advice on material quantities and specifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map and Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Location and Map -->
                <div class="col-lg-7">
                    <h3 class="text-white fw-bold mb-4 scroll-reveal">OPERATION CENTER <span class="highlight-text">- LOCATION</span></h3>
                    <div class="futuristic-card p-3 scroll-reveal" style="aspect-ratio: 16 / 9; transition-delay: 0.1s;">
                         <!-- Google Map Embed (using a placeholder iframe for demonstration) -->
                         <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.550186591176!2d112.77583337583344!3d-7.291307073289063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb21a7196655%3A0xc6e480d199990263!2sUD.Klampis%20Depo!5e0!3m2!1sen!2sid!4v1716912345678!5m2!1sen!2sid"
                            width="100%"
                            height="100%"
                            style="border:0; border-radius: 8px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                         </iframe>
                    </div>
                    <p class="text-muted mt-3 small scroll-reveal" style="transition-delay: 0.2s;">
                        <i class="bi bi-geo-alt-fill me-1 highlight-text"></i> Address: UD.Klampis Depo, Jl. Klampis Harapan No.G-168, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-5">
                    <h3 class="text-white fw-bold mb-4 scroll-reveal">DIRECT ACCESS <span class="highlight-text">- CONNECT</span></h3>

                    <!-- Tokopedia Card -->
                    <div class="futuristic-card p-4 mb-3 d-flex align-items-center scroll-reveal" style="transition-delay: 0.3s;">
                        <i class="bi bi-cart4 display-6 me-4" style="color: var(--accent-green);"></i>
                        <div>
                            <h5 class="text-white mb-1">Official E-Store</h5>
                            <a href="https://www.tokopedia.com/klampisdepo" target="_blank" class="text-decoration-none text-grey small footer-link">
                                Tokopedia /klampisdepo <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Card -->
                    <div class="futuristic-card p-4 mb-3 d-flex align-items-center scroll-reveal" style="transition-delay: 0.4s;">
                        <i class="bi bi-whatsapp display-6 me-4" style="color: var(--accent-green);"></i>
                        <div>
                            <h5 class="text-white mb-1">Quick Contact (WhatsApp)</h5>
                            <!-- Formatted for click-to-chat -->
                            <a href="https://wa.me/6285100549376" target="_blank" class="text-decoration-none text-grey small footer-link">
                                +62 85100549376 <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hours Card -->
                    <div class="futuristic-card p-4 d-flex align-items-center scroll-reveal" style="transition-delay: 0.5s;">
                        <i class="bi bi-calendar-check display-6 me-4" style="color: var(--accent-green);"></i>
                        <div>
                            <h5 class="text-grey mb-1">Operational Hours</h5>
                            <p class="text-grey small mb-0">Monday - Saturday: 07:00 - 17:00 WIB</p>
                            <p class="text-grrey small mb-0">Sunday: Closed</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-4 mt-5" style="border-top: 1px solid var(--border-color);">
        <div class="container text-center">
            <p class="text-muted mb-0 small">&copy; 2025 KLAMPIS DEPO. All rights reserved. | Powered by <span class="highlight-text">Innovation</span>.</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for Logic and Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            function updateStoreStatus() {
                const now = new Date();
                const day = now.getDay();
                const hour = now.getHours();

                const isWeekday = (day >= 1 && day <= 6);
                const isTimeOpen = (hour >= 7 && hour < 17);

                const isOpen = isWeekday && isTimeOpen;

                const indicator = document.getElementById('store-status-indicator');
                const text = document.getElementById('store-status-text');

                indicator.classList.remove('status-open', 'status-closed');

                if (isOpen) {
                    indicator.classList.add('status-open');
                    text.innerHTML = '<span class="highlight-text">STATUS: OPERATIONAL</span> (Open until 17:00 WIB)';
                    text.style.color = 'var(--accent-green)';
                } else {
                    indicator.classList.add('status-closed');
                    text.innerHTML = '<span style="color: var(--accent-red);">STATUS: CLOSED</span> (Opens Mon-Sat 07:00 WIB)';
                    text.style.color = 'var(--accent-red)';
                }
            }

            updateStoreStatus();
            setInterval(updateStoreStatus, 60000);

            const scrollElements = document.querySelectorAll('.scroll-reveal');

            const elementInView = (el, dividend = 1) => {
                const elementTop = el.getBoundingClientRect().top;
                return (
                    elementTop <=
                    (window.innerHeight || document.documentElement.clientHeight) / dividend
                );
            };

            const displayScrollElement = (element) => {
                element.classList.add('visible');
            };

            const handleScrollAnimation = () => {
                scrollElements.forEach((el) => {
                    if (elementInView(el, 1.25)) {
                        displayScrollElement(el);
                    }
                })
            }

            window.addEventListener('scroll', handleScrollAnimation);

            handleScrollAnimation();
            const buttons = document.querySelectorAll('.futuristic-button');
            buttons.forEach(btn => {
                btn.addEventListener('mouseover', () => {
                    btn.style.boxShadow = `0 0 10px var(--accent-green)`;
                });
                btn.addEventListener('mouseout', () => {
                    btn.style.boxShadow = 'none';
                });
            });
        });
    </script>

</body>
</html>
