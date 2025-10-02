<!-- Page Header Start -->

<section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-header-content text-center">
                        <h1><?php echo htmlspecialchars($pageContent['about_title'] ?? 'About EduFix University'); ?></h1>
                        <p><?php echo htmlspecialchars($pageContent['about_subtitle'] ?? 'Empowering students through innovative distance learning'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- About Content Start -->
    <section class="about-content-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="about-content">
                        <?php if (isset($pageContent['about_description'])): ?>
                            <?php echo $pageContent['about_description']; ?>
                        <?php else: ?>
                            <p>EduFix University is a leading institution in distance learning, committed to providing high-quality education accessible to students worldwide. Our innovative approach combines cutting-edge technology with proven pedagogical methods.</p>
                            <p>Founded with the vision of making education accessible to everyone, we have grown to serve thousands of students across the globe, offering diverse programs and courses designed to meet the needs of modern learners.</p>
                            <p>Our faculty consists of experienced educators and industry professionals who bring real-world expertise to the virtual classroom. We believe in fostering a supportive learning environment where students can thrive and achieve their academic and professional goals.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Content End -->

    <!-- Mission & Vision Start -->
    <section class="mission-vision-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mission-content">
                        <h3>Our Mission</h3>
                        <p>To provide accessible, high-quality education that empowers learners to achieve their full potential and contribute meaningfully to society.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="vision-content">
                        <h3>Our Vision</h3>
                        <p>To be the global leader in innovative distance learning, transforming education through technology and creating opportunities for lifelong learning.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mission & Vision End -->

    <!-- Values Start -->
    <section class="values-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center">
                        <h3>Our Values</h3>
                        <h2>What drives us forward</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>Excellence</h4>
                        <p>We strive for the highest standards in education and student support.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Inclusivity</h4>
                        <p>Education should be accessible to everyone, regardless of background or location.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation</h4>
                        <p>We embrace new technologies and teaching methods to enhance learning.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Integrity</h4>
                        <p>We maintain the highest ethical standards in all our interactions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Values End -->
