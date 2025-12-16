<?php
// Pastikan session sudah start di file induk
$current_page = basename($_SERVER['PHP_SELF']);

// Ambil foto profil terbaru jika user login
$nav_profile_pic = "default.png";
if(isset($_SESSION['user_id'])) {
    // Kita perlu query ulang untuk mendapatkan foto terbaru (karena session mungkin outdated)
    // Note: Pastikan $conn tersedia. Jika include ini di dalam function, global $conn mungkin diperlukan.
    if(isset($conn)){
        $uid = $_SESSION['user_id'];
        $nav_q = mysqli_query($conn, "SELECT profile_picture FROM users WHERE user_id='$uid'");
        if($nav_q && mysqli_num_rows($nav_q) > 0){
            $nav_data = mysqli_fetch_assoc($nav_q);
            $nav_profile_pic = $nav_data['profile_picture'];
        }
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php" style="letter-spacing: 1px;">AyoKerja</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'jobs.php' ? 'active' : '' ?>" href="jobs.php">Lowongan</a>
                </li>

                <?php if (isset($_SESSION['user_id'])) { ?>
                    
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative <?= $current_page == 'notifications.php' ? 'active' : '' ?>" href="notifications.php">
                            <i class="bi bi-bell-fill" style="font-size: 1.2rem;"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-secondary border-0 text-white d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="../assets/uploads/<?= $nav_profile_pic ?>" 
                                 alt="Profile" 
                                 class="rounded-circle" 
                                 style="width: 30px; height: 30px; object-fit: cover;">
                            <span><?= $_SESSION['full_name'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow">
                            <li><h6 class="dropdown-header">Menu Pengguna</h6></li>
                            
                            <?php if ($_SESSION['role'] == 'company') { ?>
                                <li><a class="dropdown-item" href="company_dashboard.php">Dashboard Perusahaan</a></li>
                                <li><a class="dropdown-item" href="company_jobs.php">Kelola Lowongan</a></li>
                            <?php } elseif ($_SESSION['role'] == 'admin') { ?>
                                <li><a class="dropdown-item" href="admin_dashboard.php">Admin Panel</a></li>
                            <?php } else { ?>
                                <li><a class="dropdown-item" href="profile.php">Profil Saya</a></li>
                                <li><a class="dropdown-item" href="my_applications.php">Lamaran Saya</a></li>
                            <?php } ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
                        </ul>
                    </li>

                <?php } else { ?>
                    <li class="nav-item ms-2">
                        <a href="login.php" class="btn btn-outline-light btn-sm px-3">Masuk</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="register.php" class="btn btn-primary btn-sm px-3">Daftar</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>