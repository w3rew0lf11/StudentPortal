<?php include("includes/header.php"); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title animate-pop-in">Welcome to Student Portal</h1>
                <p class="hero-text animate-pop-in">Your one-stop platform for academic success and campus life.</p>
                <div class="hero-buttons animate-pop-in">
                    <a href="login.html" class="btn btn-primary">Get Started</a>
                    <a href="#features" class="btn btn-outline">Learn More</a>
                </div>
            </div>
            <div class="hero-image animate-pop-in">
                <img src="assets/images/student-hero.png" alt="Student studying">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title">Why Choose Our Portal</h2>
            <div class="features-grid">
                <div class="feature-card animate-fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Student Profile</h3>
                    <p>Manage your academic profile and personal information in one place.</p>
                </div>
                <div class="feature-card animate-fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Course Management</h3>
                    <p>Access your course materials, assignments, and grades anytime.</p>
                </div>
                <div class="feature-card animate-fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Academic Calendar</h3>
                    <p>Stay updated with important dates and deadlines.</p>
                </div>
                <div class="feature-card animate-fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Communication</h3>
                    <p>Connect with faculty and fellow students easily.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">What Students Say</h2>
            <div class="testimonial-slider">
                <div class="testimonial-slide active">
                    <div class="testimonial-content">
                        <p>"This portal made my academic life so much easier! Everything I need is in one place."</p>
                        <div class="testimonial-author">
                            <img src="assets/images/student1.jpg" alt="Student">
                            <div>
                                <h4>Sarah Johnson</h4>
                                <p>Computer Science</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <p>"The interface is intuitive and the features are exactly what students need."</p>
                        <div class="testimonial-author">
                            <img src="assets/images/student2.jpg" alt="Student">
                            <div>
                                <h4>Michael Chen</h4>
                                <p>Business Administration</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <p>"I love how I can update my profile and upload documents easily."</p>
                        <div class="testimonial-author">
                            <img src="assets/images/student3.jpg" alt="Student">
                            <div>
                                <h4>Emily Rodriguez</h4>
                                <p>Psychology</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-controls">
                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                <div class="slider-dots"></div>
                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

<?php include("includes/footer.php"); ?>
