<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="bg-animation">
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
        <div class="wave wave4"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">

            <div class="alert-container">
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($_GET['message']); ?>
                        <button class="alert-close">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                        <button class="alert-close">&times;</button>
                    </div>
                <?php endif; ?>
            </div>
            <nav class="navbar">
                <a href="index.php" class="logo">Student<span>Portal</span></a>
                <ul class="nav-links">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="dashboard.php" class="btn btn-outline">Dashboard</a></li>
                </ul>
                <div class="hamburger">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </nav>
        </div>
    </header>