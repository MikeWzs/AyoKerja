<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AyoKerja | Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container-fluid px-4">
        
        <a class="navbar-brand fw-bold brand-title" href="index.php">
            AyoKerja
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item me-3">
                    <a class="nav-link text-white" href="pages/jobs.php">Explore Jobs</a>
                </li>

                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold btn btn-outline-secondary border-0" href="#" role="button" data-bs-toggle="dropdown">
                            <?= $_SESSION['full_name'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow">
                            
                            <?php if ($_SESSION['role'] == 'company') { ?>
                                <li><h6 class="dropdown-header">Company Access</h6></li>
                                <li><a class="dropdown-item" href="pages/company_dashboard.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="pages/company_jobs.php">My Jobs</a></li>
                                <li><a class="dropdown-item" href="pages/profile.php">Edit Profile</a></li>
                            
                            <?php } elseif ($_SESSION['role'] == 'admin') { ?>
                                <li><h6 class="dropdown-header">Admin Panel</h6></li>
                                <li><a class="dropdown-item" href="pages/admin_dashboard.php">Dashboard</a></li>

                            <?php } else { ?>
                                <li><h6 class="dropdown-header">Job Seeker</h6></li>
                                <li><a class="dropdown-item" href="pages/profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="pages/my_applications.php">My Applications</a></li>
                                <li><a class="dropdown-item" href="pages/notifications.php">Notifications</a></li>
                            <?php } ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="pages/logout.php">Logout</a></li>
                        </ul>
                    </li>

                <?php } else { ?>
                    <li class="nav-item">
                        <a href="pages/login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/register.php" class="btn btn-primary btn-sm">Register</a>
                    </li>
                <?php } ?>
            </ul>
        </div>

    </div>
</nav>

<section class="hero-section d-flex align-items-center text-white">
    <div class="container text-center">
        <h1 class="fw-bold display-5 animate-title">
            Find Your Dream Job
        </h1>

        <p class="lead mt-3">
            <span id="typing-text"></span>
        </p>

        <a href="pages/jobs.php" class="btn btn-primary btn-lg mt-4 animate-button">
            Explore Jobs
        </a>
    </div>
</section>

<section class="container my-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Why Choose AyoKerja?</h3>
        <p class="text-muted">Best platform for your career growth</p>
    </div>

    <div class="row text-center">
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-briefcase-fill"></i>
                <h5>Verified Jobs</h5>
                <p>All jobs are posted by verified companies</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-people-fill"></i>
                <h5>Trusted Companies</h5>
                <p>Top companies from various industries</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-graph-up-arrow"></i>
                <h5>Career Growth</h5>
                <p>Opportunities to grow your professional career</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold">Start Your Career Journey</h3>
                <p>Browse hundreds of job opportunities and apply easily.</p>
                <a href="pages/jobs.php" class="btn btn-primary">View Jobs</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="assets/img/workers.png" class="img-fluid rounded shadow" alt="Workers">
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-4">
    <p class="mb-0">&copy; 2025 AyoKerja. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Efek Ketik Asli
const text = "Connecting talented people with trusted companies";
let index = 0;

function typeEffect() {
    if (index < text.length) {
        document.getElementById("typing-text").innerHTML += text.charAt(index);
        index++;
        setTimeout(typeEffect, 60);
    }
}

window.onload = typeEffect;
</script>

</body>
</html>