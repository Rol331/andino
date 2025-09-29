<!-- Hero Section Start -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1><?php echo htmlspecialchars($pageContent['hero_title'] ?? 'Distance Learning, Boundless Possibilities!'); ?></h1>
                    <p><?php echo htmlspecialchars($pageContent['hero_subtitle'] ?? 'Education is a key to success and freedom from all the forces is a power and makes a person powerful'); ?></p>
                    <div class="hero-buttons">
                        <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary btn-lg"><?php echo htmlspecialchars($pageContent['hero_button_text'] ?? 'Apply Now'); ?></a>
                    </div>
                    <div class="hero-features">
                        <div class="feature-item">
                            <h5>Undergraduate</h5>
                            <p>Browse the undergraduate degrees</p>
                        </div>
                        <div class="feature-item">
                            <h5>Graduate</h5>
                            <p>Browse the graduate degrees</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="assets/images/hero-image.jpg" alt="Distance Learning" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- University Ranking Section Start -->
<section class="university-ranking-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="ranking-image">
                    <img src="assets/images/university-ranking.jpg" alt="University Ranking" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ranking-content">
                    <h2>World best higher University ranking</h2>
                    <p>Education is a key to success and freedom from all the forces is a power and makes a person powerful</p>
                    <div class="ranking-buttons">
                        <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary btn-lg">Apply Now</a>
                    </div>
                    <div class="ranking-features">
                        <div class="feature-item">
                            <h5>Undergraduate</h5>
                            <p>Browse the undergraduate degrees</p>
                        </div>
                        <div class="feature-item">
                            <h5>Graduate</h5>
                            <p>Browse the graduate degrees</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- University Ranking Section End -->

<!-- Statistics Section Start -->
<section class="statistics-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_1_number'] ?? '15,000+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_1_label'] ?? 'Students Enrolled'); ?></h4>
                    <p>Active learners globally</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_2_number'] ?? '500+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_2_label'] ?? 'Expert Instructors'); ?></h4>
                    <p>Professional educators</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_3_number'] ?? '50+'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_3_label'] ?? 'Courses Available'); ?></h4>
                    <p>Diverse learning paths</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number"><?php echo htmlspecialchars($pageContent['stat_4_number'] ?? '95%'); ?></div>
                    <h4><?php echo htmlspecialchars($pageContent['stat_4_label'] ?? 'Success Rate'); ?></h4>
                    <p>Student satisfaction</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Statistics Section End -->

<!-- Features Section Start -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="feature-content">
                    <h2>Scholarship Facility</h2>
                    <p>It is a long established fact that a reader will be distracted readable content of a page when looking at its layout skill.</p>
                    <div class="feature-number">01</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-content">
                    <h2>Book Library & Store</h2>
                    <p>Perfection is long established fact that a reader will be distracted by the readable content of a page when looking at skill.</p>
                    <div class="feature-number">02</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features Section End -->

<!-- About Section Start -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="about-badge">Since <strong>1996</strong></div>
                    <h3>Get to know us</h3>
                    <h2>Dedicated to academic excellence inclusion, research</h2>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="assets/images/about-image.jpg" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Courses Section Start -->
<section class="courses-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['courses_title'] ?? 'Featured Courses'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['courses_subtitle'] ?? 'Discover our most popular courses designed to help you achieve your goals'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($featuredCourses)): ?>
                <?php foreach ($featuredCourses as $course): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="course-card">
                            <div class="course-image">
                                <img src="<?php echo $course['featured_image'] ?: 'assets/images/course-placeholder.jpg'; ?>" alt="<?php echo $course['title']; ?>" class="img-fluid">
                            </div>
                            <div class="course-content">
                                <h4><?php echo $course['title']; ?></h4>
                                <p><?php echo $course['short_description']; ?></p>
                                <ul class="course-features">
                                    <li><i class="fas fa-utensils"></i> Canteen</li>
                                    <li><i class="fas fa-bed"></i> Hotel</li>
                                    <li><i class="fas fa-book"></i> Library</li>
                                    <li><i class="fas fa-gamepad"></i> Playground</li>
                                    <li><i class="fas fa-flask"></i> Lab</li>
                                </ul>
                                <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Courses Section End -->

<!-- Campus Highlights Section Start -->
<section class="campus-highlights-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="highlights-content">
                    <h2>Campus Highlights</h2>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="highlights-grid">
                    <div class="highlight-item">
                        <h4>Student Life</h4>
                        <p>There are many variations of passages of available, but the majority have suffered alteration in injected humour to access.</p>
                    </div>
                    <div class="highlight-item">
                        <h4>Arts & Clubs</h4>
                        <p>Maximum are many variations of passages of available, but the majority have suffered alteration in injected humour to access.</p>
                    </div>
                    <div class="highlight-item">
                        <h4>Sports & Fitness</h4>
                        <p>Perfect are many variations of passages of available, but the majority have suffered alteration in injected humour to access.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Campus Highlights Section End -->

<!-- Tuition Section Start -->
<section class="tuition-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3>Tuition & Fees</h3>
                    <h2>The University Tuition & Fees</h2>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Faculty Of Science</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2029</div>
                        <div class="department">Graduate Department</div>
                        <div class="fees">
                            <p>Full Time (per semester): <strong>$20,00</strong></p>
                            <p>Part Time (per credit): <strong>$16,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Technology Fee: <strong>$14,000</strong></p>
                            <p>Student Activity Fee: <strong>$10,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Economics, BA</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2027</div>
                        <div class="department">Graduate Department</div>
                        <div class="fees">
                            <p>Full Time (per semester): <strong>$26,00</strong></p>
                            <p>Part Time (per credit): <strong>$38,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Technology Fee: <strong>$18,000</strong></p>
                            <p>Student Activity Fee: <strong>$20,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>M.A. in Education</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2027</div>
                        <div class="department">Graduate Department</div>
                        <div class="fees">
                            <p>Full Time (per semester): <strong>$13,00</strong></p>
                            <p>Part Time (per credit): <strong>$18,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Technology Fee: <strong>$15,000</strong></p>
                            <p>Student Activity Fee: <strong>$14,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="tuition-card">
                    <h4>Business Media</h4>
                    <div class="tuition-details">
                        <div class="program-duration">2025 - 2028</div>
                        <div class="department">Graduate Department</div>
                        <div class="fees">
                            <p>Full Time (per semester): <strong>$23,00</strong></p>
                            <p>Part Time (per credit): <strong>$12,00</strong></p>
                        </div>
                        <div class="additional-fees">
                            <p>Technology Fee: <strong>$17,000</strong></p>
                            <p>Student Activity Fee: <strong>$15,000</strong></p>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Tuition Section End -->

<!-- Events Section Start -->
<section class="events-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['events_title'] ?? 'Upcoming Events'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['events_subtitle'] ?? 'Join our exciting events and connect with the community'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($upcomingEvents)): ?>
                <?php foreach ($upcomingEvents as $event): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="event-card">
                            <div class="event-date">
                                <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                                <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?>, <?php echo date('Y', strtotime($event['event_date'])); ?></span>
                            </div>
                            <div class="event-content">
                                <h4><?php echo $event['title']; ?></h4>
                                <div class="event-meta">
                                    <span><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($event['event_date'])); ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo $event['location']; ?></span>
                                </div>
                                <a href="<?php echo BASE_URL; ?>events" class="btn btn-outline-primary">Book a ticket</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Events Section End -->

<!-- Admission Form Section Start -->
<section class="admission-form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="admission-form">
                    <h3>Admission Form</h3>
                    <p>Please fill in the form carefully and make sure all information is accurate*</p>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Home Phone</label>
                                    <input type="tel" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State / Province</label>
                                    <input type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Street Address</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Select Department</label>
                            <select class="form-control" required>
                                <option value="">Choose Department</option>
                                <option value="faculty-of-science">Faculty Of Science</option>
                                <option value="economics-ba">Economics, BA</option>
                                <option value="ma-education">M.A. in Education</option>
                                <option value="business-media">Business Media</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Apply Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Admission Form Section End -->

<!-- Blog Section Start -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center">
                    <h3><?php echo htmlspecialchars($pageContent['blog_title'] ?? 'Latest News & Updates'); ?></h3>
                    <h2><?php echo htmlspecialchars($pageContent['blog_subtitle'] ?? 'Stay informed with our latest news and educational content'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($recentPosts)): ?>
                <?php foreach ($recentPosts as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card">
                            <div class="blog-image">
                                <img src="<?php echo $post['featured_image'] ?: 'assets/images/blog-placeholder.jpg'; ?>" alt="<?php echo $post['title']; ?>" class="img-fluid">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span class="category">Courses</span>
                                    <span class="date"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                                </div>
                                <h4><?php echo $post['title']; ?></h4>
                                <p><?php echo $post['excerpt']; ?></p>
                                <a href="<?php echo BASE_URL; ?>blog" class="read-more">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Blog Section End -->
