<?php include("includes/header.php"); ?>
<div class="form-container">
    <!-- Auth Section -->
    <section class="auth-section">
        <div class="container">
            <div class="auth-container animate-slide-up">
                <div class="auth-image">
                    <img src="assets/images/login.jpg" alt="Student portal illustration">
                </div>
                <div class="auth-forms">
                    <div class="auth-form active" id="loginForm">
                        <h2>Welcome Back!</h2>
                        <p>Please login to access your student dashboard.</p>

                        <form class="form" method="POST" action="includes/loginProcess.php">
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="loginEmail" placeholder="Email Address" name="email"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Password</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="loginPassword" name="password"
                                        placeholder="Enter your password" required>
                                    <button type="button" class="toggle-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>

                            <div class="auth-divider">
                                <span></span>
                            </div>


                            <p class="auth-switch">Don't have an account? <a href="#" class="switch-form"
                                    data-target="registerForm">Register here</a></p>
                        </form>
                    </div>

                    <!-- Registration Form -->
                    <div class="auth-form" id="registerForm">
                        <h2>Create Account</h2>
                        <p>Join our student community today.</p>

                        <form class="form" method="POST" action="includes/registrationProcess.php">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstname"
                                        placeholder="Enter your first name" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastname" placeholder="Enter your last name"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" id="loginEmail" placeholder="Email Address" name="email"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="registerPassword">Password</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="registerPassword" name="password"
                                            placeholder="Create password" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="confirmPassword" name="confirm_password"
                                            placeholder="Confirm password" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>

                            <div class="auth-divider">
                                <span></span>
                            </div>



                            <p class="auth-switch">Already have an account? <a href="#registerForm" class="switch-form"
                                    data-target="loginForm">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("includes/footer.php"); ?>