<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Arsha Bootstrap Template - Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo BASE_URL; ?>public/assets/img/favicon.png" rel="icon">
    <link href="<?php echo BASE_URL; ?>public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo BASE_URL; ?>public/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="landing.php">TIENDA REGRAGON</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.php" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
                    <li><a class="nav-link scrollto" href="#about">Sobre Nosotros</a></li>
                    <li><a class="nav-link scrollto" href="#services">Servicios</a></li>
                    <li><a class="nav-link   scrollto" href="#portfolio">Productos</a></li>
                    <li><a class="nav-link scrollto" href="#team">Esquipo</a></li>
                    
                    <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
                    <li><a href="<?php echo BASE_URL; ?>usuario/login" class="getstarted scrollto">Iniciar Sesión</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>Los mejores en accesorios y perifericos</h1>
                    <h2>DE COMPUTADORAS</h2>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="#about" class="btn-get-started scrollto">Iniciar</a>                        
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="<?php echo BASE_URL; ?>public/assets/img/store4.jpg" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Sobre Nosotros</h2>
                </div>

                <!-- vista/home/dashboard.php (sección a modificar dentro del archivo) -->
                <div class="row content">
                    <div class="col-lg-6">
                        <p>
                            En Redragon Accesorios, nos dedicamos a ofrecer los mejores periféricos y accesorios para computadoras, diseñados para gamers y profesionales. Nuestra misión es proporcionar productos de alta calidad que mejoren tu experiencia tecnológica.
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Amplia variedad de teclados, mouse y auriculares de última generación</li>
                            <li><i class="ri-check-double-line"></i> Soporte técnico especializado para todos nuestros clientes</li>
                            <li><i class="ri-check-double-line"></i> Envíos rápidos y seguros a todo el país</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p>
                            Trabajamos con las marcas más reconocidas del mercado para garantizar durabilidad y rendimiento. Nuestro equipo está comprometido con la satisfacción del cliente, ofreciendo soluciones innovadoras para tus necesidades de gaming y trabajo. ¡Únete a nuestra comunidad hoy!
                        </p>
                        <a href="<?php echo BASE_URL; ?>acerca-de" class="btn-learn-more">Conoce más</a>
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->

        <!-- ======= Skills Section ======= -->
        <section id="skills" class="skills">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
                        <img src="<?php echo BASE_URL; ?>public/assets/img/venta.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                        <h3>Ventas mas vendidas </h3>
                        <p class="fst-italic">
                            Descubre los accesorios y periféricos que lideran nuestras ventas este mes: teclados gaming Redragon, mouse ergonómicos, y auriculares con micrófono de alta calidad. ¡Explora las estadísticas detalladas a continuación!
                        </p>

                        <div class="skills-content">

                            <div class="progress">
                                <span class="skill">Teclados <i class="val">100%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="progress">
                                <span class="skill">Camaras <i class="val">90%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="progress">
                                <span class="skill">Mouse <i class="val">75%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="progress">
                                <span class="skill">Auriculares <i class="val">55%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </section><!-- End Skills Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container" data-aos="fade-up">

                <!-- vista/home/dashboard.php (sección a modificar dentro del archivo) -->
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>En Redragon Accesorios ofrecemos soluciones integrales para tus necesidades de gaming y trabajo. Desde la venta de periféricos de alta calidad hasta soporte técnico especializado, estamos comprometidos con tu satisfacción y el rendimiento de tu equipo.</p>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-shopping-bag"></i></div> <!-- Ícono de carrito de compras -->
                        <h4><a href="#">Venta de Periféricos</a></h4>
                        <p>Encuentra teclados, mouse y auriculares de última generación para optimizar tu experiencia de juego o trabajo.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-support"></i></div> <!-- Ícono de soporte -->
                        <h4><a href="#">Soporte Técnico</a></h4>
                        <p>Ofrecemos asistencia especializada para configurar y mantener tus accesorios en perfectas condiciones.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-truck"></i></div> <!-- Ícono de entrega -->
                        <h4><a href="#">Envío Rápido</a></h4>
                        <p>Recibe tus productos en cualquier parte del país con envíos seguros y entregas a tiempo.</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-wrench"></i></div> <!-- Ícono de herramientas -->
                        <h4><a href="#">Reparación y Mantenimiento</a></h4>
                        <p>Garantizamos la durabilidad de tus periféricos con servicios de reparación y mantenimiento profesional.</p>
                    </div>
                </div>
</div>

            </div>
        </section><!-- End Services Section -->

        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
            <div class="container" data-aos="zoom-in">

               

            </div>
        </section><!-- End Cta Section -->

        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">

                <!-- vista/home/dashboard.php (sección a modificar dentro del archivo) -->
                <div class="section-title">
                    <h2>Nuestros productos</h2>
                    <p>En Redragon Accesorios te ofrecemos una amplia gama de periféricos y accesorios de computadora de alta calidad. Desde teclados gaming hasta mouse ergonómicos y auriculares avanzados, encuentra todo lo que necesitas para potenciar tu experiencia tecnológica.</p>
                </div>

                <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">Todos</li>
                    <li data-filter=".filter-app">Teclados</li>
                    <li data-filter=".filter-card">Mouses</li>
                    <li data-filter=".filter-web">Audifonos</li>
                </ul>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado1.webp" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Teclado Cafini</h4>
                            <p>Teclado mecanico con rbg</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado1.webp" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono1.webp" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Audifono Redragon 3</h4>
                            <p>Audifono</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono1.webp" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado2.webp" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Teclado Redragon</h4>
                            <p>Teclado mecanico con rbg</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado2.webp" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse1.webp" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Mouse Redragon</h4>
                            <p>Mouse con dpi</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse1.webp" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono2.jpeg" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Audifono Redragon 3</h4>
                            <p>Audifono Redragon 3</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono2.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado3.webp" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Teclado Altisimo</h4>
                            <p>Teclado mecanico con rbg</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/teclado3.webp" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse2.jpeg" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Mouse Logitec</h4>
                            <p>Mouse con dpi</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse2.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse3.jpeg" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Mouse Altisimo</h4>
                            <p>Mouse con dpi</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/mouse3.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-img"><img src="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono3.jpg" class="img-fluid" alt=""></div>
                        <div class="portfolio-info">
                            <h4>Audifono Redragon</h4>
                            <p>Audifono Redragon</p>
                            <a href="<?php echo BASE_URL; ?>public/assets/img/portfolio/audifono3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.php" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Portfolio Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container" data-aos="fade-up">

                <!-- vista/home/dashboard.php (sección a modificar dentro del archivo) -->
                <div class="section-title">
                    <h2>Equipo</h2>
                    <p>Conoce al talentoso equipo detrás de Redragon Accesorios. Nuestro personal trabaja incansablemente para ofrecerte los mejores periféricos y servicios, garantizando calidad y satisfacción en cada paso del proceso.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo BASE_URL; ?>public/assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Julio Ticona</h4>
                                <span>Director General</span>
                                <p>Lidera la visión estratégica de la empresa, enfocándose en la expansión y calidad de nuestros productos tecnológicos.</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo BASE_URL; ?>public/assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Josue Mamani</h4>
                                <span>Cajero</span>
                                <p>Coordina el desarrollo y selección de accesorios de alta calidad para satisfacer las necesidades de nuestros clientes.</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo BASE_URL; ?>public/assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Kevin Paco</h4>
                                <span>Vendedor</span>
                                <p>Garantiza la innovación en nuestros periféricos, integrando las últimas tendencias tecnológicas.</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo BASE_URL; ?>public/assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Rocio Mamani</h4>
                                <span>Contadora</span>
                                <p>Gestiona las finanzas de la empresa, asegurando la estabilidad económica y el crecimiento sostenible.</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
                        <div class="member d-flex align-items-start">
                            <div class="pic"><img src="<?php echo BASE_URL; ?>public/assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Camila Salas</h4>
                                <span>Contadora</span>
                                <p>Gestiona las finanzas de la empresa, asegurando la estabilidad económica y el crecimiento sostenible.</p>
                                <div class="social">
                                    <a href=""><i class="ri-twitter-fill"></i></a>
                                    <a href=""><i class="ri-facebook-fill"></i></a>
                                    <a href=""><i class="ri-instagram-fill"></i></a>
                                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Team Section -->

        <!-- ======= Pricing Section ======= -->
        <!-- <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Pricing</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row">

                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="box">
                            <h3>Free Plan</h3>
                            <h4><sup>$</sup>0<span>per month</span></h4>
                            <ul>
                                <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
                                <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>
                                <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
                            </ul>
                            <a href="#" class="buy-btn">Get Started</a>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="box featured">
                            <h3>Business Plan</h3>
                            <h4><sup>$</sup>29<span>per month</span></h4>
                            <ul>
                                <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
                                <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
                                <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
                            </ul>
                            <a href="#" class="buy-btn">Get Started</a>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="box">
                            <h3>Developer Plan</h3>
                            <h4><sup>$</sup>49<span>per month</span></h4>
                            <ul>
                                <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
                                <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
                                <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
                            </ul>
                            <a href="#" class="buy-btn">Get Started</a>
                        </div>
                    </div>

                </div>

            </div>
        </section>End Pricing Section -->

        

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <!-- vista/home/dashboard.php (sección a modificar dentro del archivo) -->
                <div class="section-title">
                    <h2>Contáctanos</h2>
                    <p>¿Tienes alguna pregunta sobre nuestros periféricos o necesitas asistencia? En Redragon Accesorios estamos aquí para ayudarte. Contáctanos a través de los siguientes canales y nuestro equipo te responderá lo antes posible.</p>
                </div>

                <div class="row">

                    <div class="col-lg-5 d-flex align-items-stretch">
                        <div class="info">
                            <div class="address">
                                <i class="bi bi-geo-alt"></i>
                                <h4>Direccion:</h4>
                                <p>Zona Miraflores, Calle Junin, Nro 234</p>
                            </div>

                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p>mitienda@gmail.com</p>
                            </div>

                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4>Celular:</h4>
                                <p>69768248</p>
                            </div>

                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d239.0933186446642!2d-68.13172850513283!3d-16.501185433028738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f20701ba18005%3A0xffe800b1d4669d9a!2sInstituto%20T%C3%A9cnico%20Comercial%20Superior%20de%20la%20Naci%C3%B3n%20%22Tte.%20Armando%20de%20Palacios%22%20-%20INCOS%20La%20Paz!5e0!3m2!1ses!2sbo!4v1751255226765!5m2!1ses!2sbo" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                    </div>

                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Tu Nombre</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">Tu Correo</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Asunto</label>
                                <input type="text" class="form-control" name="subject" id="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Mensaje</label>
                                <textarea class="form-control" name="message" rows="10" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Enviando</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Tu mensaje ha sido enviado. Muchas gracias!</div>
                            </div>
                            <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        
        <!-- vista/home/dashboard.php (sección a modificar dentro del archivo, probablemente en footer.php si es un layout) -->
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Redragon Accesorios</h3>
                        <p>
                            Av. Principal 123 <br>
                            La Paz, Bolivia <br><br>
                            <strong>Teléfono:</strong> +591 69768248<br>
                            <strong>Email:</strong> info@redragonaccesorios.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Enlaces Útiles</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>acerca-de">Acerca de nosotros</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios">Servicios</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>terminos">Términos de servicio</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>privacidad">Política de privacidad</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Nuestros Servicios</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios/venta">Venta de Periféricos</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios/soporte">Soporte Técnico</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios/envio">Envío Rápido</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios/reparacion">Reparación y Mantenimiento</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?php echo BASE_URL; ?>servicios/garantia">Garantía de Productos</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Nuestras Redes Sociales</h4>
                        <p>Conéctate con nosotros para las últimas novedades en accesorios y periféricos</p>
                        <div class="social-links mt-3">
                            <a href="https://twitter.com/redragonaccesorios" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="https://facebook.com/redragonaccesorios" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="https://instagram.com/redragonaccesorios" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="https://wa.me/59171234567" class="google-plus"><i class="bx bxl-whatsapp"></i></a> <!-- Cambié a WhatsApp -->
                            <a href="https://linkedin.com/company/redragonaccesorios" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>Julio Ticona</span></strong>. Incos LA PAZ
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
                Bolivia <a href="https://bootstrapmade.com/">2025</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/aos/aos.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="<?php echo BASE_URL; ?>public/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo BASE_URL; ?>public/assets/js/main.js"></script>

</body>

</html>