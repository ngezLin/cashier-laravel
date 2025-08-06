<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klampis Depo - Building Materials & Construction Supplies</title>
    <meta name="description" content="Klampis Depo - Your trusted partner for quality building materials and construction supplies in Surabaya. We offer cement, steel, lumber, tiles, paint, and hardware.">


    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/responsive.css') }}">
    <link rel="icon" href="{{ asset('dist/images/store.png') }}" type="image/gif">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
</head>
<body>
    <!-- Header -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand color" href="#">Klampis Depo</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                        <li class="nav-item">
                            @auth
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            @else
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Banner -->
        <section class="banner_section layout_padding" id="home">
            <div class="container">
                <div class="banner_taital_main">
                    <h1 class="banner_taital">Klampis <br> Depo</h1>
                    <p class="banner_text">Your trusted partner for quality building materials and construction supplies.</p>
                </div>
            </div>
        </section>
    </header>

    <!-- About Section -->
    <section class="about_section layout_padding" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about_taital_box">
                        <h1 class="about_taital">About Our Store</h1>
                        <h2 class="about_taital_1">Building Materials Specialist</h2>
                        <p class="about_text">With over 15 years of experience in the building materials industry, Klampis Depo has been serving contractors, builders, and homeowners in Surabaya with quality products and exceptional service. We offer a comprehensive range of construction materials from trusted brands at competitive prices.</p>
                        <a href="#products" class="readmore_btn">View Products</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('dist/images/about1-img.png') }}" class="about_img" alt="Klampis Depo Store" style="width: 300px; height: 300px; object-fit: cover;">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="coffee_section layout_padding" id="products">
        <div class="container">
            <h1 class="coffee_taital">OUR PRODUCT CATEGORIES</h1>
        </div>

        <div class="coffee_section_2">
            <div id="main_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/cement-img.png') }}" alt="Cement & Concrete"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">CEMENT & CONCRETE</h3>
                                        <p class="looking_text">High-quality cement, ready-mix concrete, and concrete blocks for all construction needs.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/steel-img.png') }}" alt="Steel & Metal"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">STEEL & METAL</h3>
                                        <p class="looking_text">Rebar, steel beams, metal sheets, and structural steel materials.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/lumber-img.png') }}" alt="Lumber & Wood"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">LUMBER & WOOD</h3>
                                        <p class="looking_text">Premium lumber, plywood, and wooden materials for construction.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/tiles-img.png') }}" alt="Tiles & Flooring"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">TILES & FLOORING</h3>
                                        <p class="looking_text">Ceramic tiles, marble, granite, and various flooring options.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/cement-img.png') }}" alt="Paint & Finishes"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">PAINT & FINISHES</h3>
                                        <p class="looking_text">Wide selection of paints, primers, and finishing materials.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/steel-img.png') }}" alt="Tools & Hardware"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">TOOLS & HARDWARE</h3>
                                        <p class="looking_text">Professional tools, fasteners, and hardware supplies.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/lumber-img.png') }}" alt="Electrical Supplies"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">ELECTRICAL SUPPLIES</h3>
                                        <p class="looking_text">Cables, switches, outlets, and electrical installation materials.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="coffee_img"><img src="{{ asset('dist/images/tiles-img.png') }}" alt="Plumbing Materials"></div>
                                    <div class="coffee_box">
                                        <h3 class="types_text">PLUMBING MATERIALS</h3>
                                        <p class="looking_text">Pipes, fittings, fixtures, and plumbing installation supplies.</p>
                                        <a href="#" class="read_bt">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#main_slider" data-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a class="carousel-control-next" href="#main_slider" data-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="client_section layout_padding" id="services">
        <div class="container">
            <div id="custom_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h1 class="about_taital">Our Services</h1>
                        <div class="client_section_2">
                            <div class="client_taital_main">
                                <div class="client_left">
                                    <img src="{{ asset('dist/images/about1-img.png') }}" alt="Delivery Service" class="client_img">
                                </div>
                                <div class="client_right">
                                    <h3 class="moark_text">Affordable Delivery</h3>
                                    <p class="client_text">We provide affordable delivery service for orders above minimum purchase within Surabaya city area. Our professional delivery team ensures your materials arrive safely and on time at your construction site.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <h1 class="about_taital">Expert Consultation</h1>
                        <div class="client_section_2">
                            <div class="client_taital_main">
                                <div class="client_left">
                                    <img src="{{ asset('dist/images/about1-img.png') }}" alt="Expert Consultation" class="client_img">
                                </div>
                                <div class="client_right">
                                    <h3 class="moark_text">Material Estimation</h3>
                                    <p class="client_text">Our experienced team provides professional material calculation and estimation services for your construction projects. Get expert advice on material selection, quantities, and cost-effective solutions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <h1 class="about_taital">Online Shopping</h1>
                        <div class="client_section_2">
                            <div class="client_taital_main">
                                <div class="client_left">
                                    <img src="{{ asset('dist/images/about1-img.png') }}" alt="Online Shopping" class="client_img">
                                </div>
                                <div class="client_right">
                                    <h3 class="moark_text">Shop Online</h3>
                                    <p class="client_text">Visit our online store on Tokopedia and other e-commerce platforms. Browse our complete catalog, check prices, and place orders from the comfort of your home or office.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#custom_slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#custom_slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact_section layout_padding" id="contact">
        <div class="container">
            <h1 class="contact_taital">Get In Touch</h1>
        </div>
        <div class="container-fluid">
            <div class="contact_section_2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mail_section_1 text-center">
                            <a href="https://wa.me/6285100549376?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20barang%20Anda."
                               target="_blank"
                               class="btn btn-success"
                               style="padding: 12px 24px; font-size: 18px; border-radius: 8px; background-color: #25D366; color: white; text-decoration: none;">
                                <i class="fa fa-whatsapp" style="margin-right: 8px;"></i> Chat via WhatsApp
                            </a>
                        </div>
                    </div>
                    <div class="map_main">
                        <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.125332253869!2d112.7793589!3d-7.2952918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fa5b4b0bfce1%3A0xa07b8b8602f4a3db!2sUD.%20Klampis%20Depo!5e0!3m2!1sen!2sid!4v1692960721066!5m2!1sen!2sid"
                                width="600"
                                height="450"
                                frameborder="0"
                                style="border:0; width: 100%;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer_section layout_padding">
        <div class="container">
            <div class="footer_social_icon">
                <ul>
                    <li><a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" aria-label="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
            <div class="location_text">
                <ul>
                    <li>
                        <a href="tel:+6285100549376">
                            <i class="fa fa-phone"></i>
                            <span class="padding_left_10">+6285100549376</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:klampisdepo@gmail.com">
                            <i class="fa fa-envelope"></i>
                            <span class="padding_left_10">klampisdepo@gmail.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.google.com/maps?ll=-7.295334,112.779541&z=16&t=m&hl=en&gl=ID&mapclient=embed&cid=11563989875895346139">
                            <i class="fa fa-map-marker"></i>
                            <span class="padding_left_10">Jl. Klampis Harapan, Surabaya</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
</body>
</html>
