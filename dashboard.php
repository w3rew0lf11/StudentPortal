<?php

session_start();
include("includes/database.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from auth table
$user_id = $_SESSION['user_id'];
$auth_query = mysqli_prepare($connection, "SELECT id, firstname, lastname, email FROM auth WHERE id = ?");
if (!$auth_query) {
    die("Prepare failed: " . mysqli_error($connection));
}
mysqli_stmt_bind_param($auth_query, "i", $user_id);
mysqli_stmt_execute($auth_query);
$auth_result = mysqli_stmt_get_result($auth_query);
$user = mysqli_fetch_assoc($auth_result);

if (!$user) {
    die("User not found");
}

// Fetch profile data
$profile = [];
$profile_query = mysqli_prepare($connection, "SELECT phone, program, profile_img, bio FROM profile WHERE user_id = ?");
if ($profile_query) {
    mysqli_stmt_bind_param($profile_query, "i", $user_id);
    mysqli_stmt_execute($profile_query);
    $profile_result = mysqli_stmt_get_result($profile_query);
    $profile = mysqli_fetch_assoc($profile_result) ?: [];
}

$user = array_merge($user, $profile);

$default_profile_img = "uploads/profile_photos/default_profile.jpg";
$profile_img = $default_profile_img;

if (!empty($user['profile_img'])) {
    $img_path = ltrim($user['profile_img'], '/');  
    $full_path = __DIR__ . '/' . $img_path;

    if (file_exists($full_path) && is_file($full_path)) {
        $profile_img = $img_path; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <!-- Header -->
    <header class="dashboard-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.html">Student<span>Portal</span></a>
                </div>
                <div class="header-right">
                    <button class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="user-menu">
                        <div class="user-info">
                            <span
                                class="user-name"><?= htmlspecialchars($user["firstname"] . " " . $user["lastname"]) ?></span>
                            <span class="user-role">Student</span>
                        </div>
                        <div class="user-avatar">
                            <img src="<?= htmlspecialchars($profile_img) ?>" alt="Profile Photo">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="dashboard-sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="#" class="dashboard-link active" data-section="dashboard">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dashboard-link" data-section="profile">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dashboard-link" data-section="courses">
                            <i class="fas fa-book"></i>
                            <span>My Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php" class="logout-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-content">
            <!-- Dashboard Section -->
            <section id="dashboard-section" class="content-section active">
                <h1 class="section-title">Dashboard Overview</h1>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Active Courses</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Pending Assignments</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>2</h3>
                            <p>Upcoming Exams</p>
                        </div>
                    </div>
                </div>

                <div class="recent-activities">
                    <h2>Recent Activities</h2>
                    <div class="activity-list">
                        <!-- Activity items would go here -->
                    </div>
                </div>
            </section>

            <!-- Profile Section -->


            <section id="profile-section" class="content-section">
                <div class="profile-header">
                    <h1 class="section-title">My Profile</h1>
                    <div class="profile-actions">
                        <button id="edit-profile-btn" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                        <button id="delete-profile-btn" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete Profile
                        </button>
                    </div>
                </div>


                <div class="profile-view">
                    <div class="profile-image-container">
                        <?php if (!empty($user['profile_img'])): ?>
                            <!-- Show the uploaded profile image with verified badge -->
                            <img src="<?= htmlspecialchars($profile_img) ?>" alt="Profile Photo">
                            <span class="profile-verified-badge" title="Verified Profile">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        <?php else: ?>
                            <!-- Fallback to default image if no profile image exists -->
                            <img src="uploads/profile_photos/default_profile.jpg" alt="Default Profile Photo">
                        <?php endif; ?>
                    </div>

                    <div class="profile-details">
                        <div class="detail-row">
                            <span class="detail-label">Full Name:</span>
                            <span class="detail-value">
                                <?= htmlspecialchars($user["firstname"] . " " . $user["lastname"]) ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">
                                <?= htmlspecialchars($user["email"]) ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Phone Number:</span>
                            <span class="detail-value">
                                <?= !empty($user["phone"]) ? htmlspecialchars($user["phone"]) : "Not Provided" ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Student ID:</span>
                            <span class="detail-value">
                                ST<?= htmlspecialchars($user["id"]) ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Program:</span>
                            <span class="detail-value">
                                <?= !empty($user["program"]) ? htmlspecialchars($user["program"]) : "Not Provided" ?>
                            </span>
                        </div>


                        <div class="detail-row">
                            <span class="detail-label">Bio:</span>
                            <span class="detail-value">
                                <?= !empty($user["bio"]) ? nl2br(htmlspecialchars($user["bio"])) : "No bio available." ?>
                            </span>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Courses Section -->
            <section id="courses-section" class="content-section">
                <h1 class="section-title">My Courses</h1>
                <div class="courses-grid">
                    <!-- Course cards would go here -->
                </div>
            </section>

            <!-- Edit Profile Modal -->
            <div id="edit-profile-modal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2>Edit Profile</h2>
                    <form id="profile-form" method="POST" action="includes/profile.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="profile-pic">Profile Photo <span class="required">*</span></label>

                            <div class="file-upload">
                                <label for="profile-pic" class="file-upload-label">
                                    <i class="fas fa-upload"></i> Choose Image
                                </label>
                                <input type="file" id="profile-pic" name="profile_pic" accept="image/png, image/jpeg"
                                    style="display: none;" required>
                                <span class="file-name">No file chosen</span>
                            </div>

                            <small class="file-hint">Max. 2MB (JPG, PNG)</small>
                        </div>


                        <div class="form-group">
                            <label for="first-name">First Name <span class="required">*</span></label>
                            <input type="text" id="first-name" value="<?= htmlspecialchars($user['firstname']) ?>"
                                name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name <span class="required">*</span></label>
                            <input type="text" id="last-name" value="<?= htmlspecialchars($user['lastname']) ?>"
                                name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" name="email"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone"
                                value="<?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '' ?>"
                                name="phone">
                        </div>
                        <div class="form-group">
                            <label for="program">Program/Course</label>
                            <select id="program" name="program">
                                <option value="">Select your program</option>
                                <option value="Computer Science" <?= (!empty($user['program']) && $user['program'] == 'Computer Science') ? 'selected' : '' ?>>Computer Science</option>
                                <option value="Business Administration" <?= (!empty($user['program']) && $user['program'] == 'Business Administration') ? 'selected' : '' ?>>Business
                                    Administration</option>
                                <option value="Electrical Engineering" <?= (!empty($user['program']) && $user['program'] == 'Electrical Engineering') ? 'selected' : '' ?>>Electrical
                                    Engineering</option>
                                <option value="Mechanical Engineering" <?= (!empty($user['program']) && $user['program'] == 'Mechanical Engineering') ? 'selected' : '' ?>>Mechanical
                                    Engineering</option>
                                <option value="Information Technology" <?= (!empty($user['program']) && $user['program'] == 'Information Technology') ? 'selected' : '' ?>>Information
                                    Technology</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea id="bio" rows="3"
                                name="bio"><?= !empty($user['bio']) ? htmlspecialchars($user['bio']) : '' ?></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary cancel-edit">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="saveProfile">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Profile Confirmation Modal -->
            <div id="delete-profile-modal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <div class="delete-confirmation">
                        <div class="delete-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h2>Delete Your Profile?</h2>
                        <p>This action cannot be undone. All your data, including courses and progress, will be
                            permanently deleted.</p>
                        <div class="confirmation-actions">
                            <button class="btn btn-secondary cancel-delete">Cancel</button>
                            <form id="delete-profile-form" method="POST" action="includes/deleteProfile.php"
                                style="display: none;"></form>
                            <button class="btn btn-danger confirm-delete"
                                onclick="document.getElementById('delete-profile-form').submit();">
                                Delete My Profile
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Dashboard JavaScript -->
    <script src="js/dashboard.js"></script>
</body>

</html>