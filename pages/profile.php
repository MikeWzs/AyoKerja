<?php
session_start();
include "../config/database.php";

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// --- PROSES UPLOAD & UPDATE ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $summary   = mysqli_real_escape_string($conn, $_POST['summary']);
    
    // Logika Upload Foto
    $upload_ok = true;
    $pic_query_part = "";
    
    // Cek apakah ada file yang diupload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        
        // Buat folder jika belum ada (antisipasi error)
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_ext = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
        // Rename file agar unik: user_id_timestamp.ext
        $new_file_name = $user_id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $new_file_name;
        
        // Validasi Tipe File
        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array($file_ext, $allowed)) {
            $msg = "<div class='alert alert-danger'>Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</div>";
            $upload_ok = false;
        }
        
        // Validasi Ukuran (Max 2MB)
        if ($_FILES["profile_pic"]["size"] > 2000000) {
            $msg = "<div class='alert alert-danger'>Ukuran file terlalu besar (Max 2MB).</div>";
            $upload_ok = false;
        }

        if ($upload_ok) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $pic_query_part = ", profile_picture='$new_file_name'";
            } else {
                $msg = "<div class='alert alert-danger'>Gagal mengupload gambar ke server.</div>";
            }
        }
    }

    // Update Database
    if ($upload_ok) {
        $update = "UPDATE users SET full_name='$full_name', phone_number='$phone', summary='$summary' $pic_query_part WHERE user_id='$user_id'";
        
        if (mysqli_query($conn, $update)) {
            $_SESSION['full_name'] = $full_name; // Update nama di session agar navbar berubah
            $msg = "<div class='alert alert-success alert-dismissible fade show'>Profil berhasil disimpan! <button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
        } else {
            $msg = "<div class='alert alert-danger'>Database Error: " . mysqli_error($conn) . "</div>";
        }
    }
}

// --- AMBIL DATA USER TERBARU ---
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Set default pic jika kosong atau file tidak ditemukan
$profile_pic = !empty($data['profile_picture']) ? $data['profile_picture'] : 'default.png';
// Fallback jika file fisik tidak ada, pakai default
if (!file_exists("../assets/uploads/" . $profile_pic)) {
    $profile_pic = "default.png"; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Saya | AyoKerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* CSS KHUSUS HALAMAN PROFILE */
        /* Banner Gradient Biru-Hitam */
        .profile-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #000000 90%);
            height: 200px;
            width: 100%;
            border-radius: 0 0 0 0; 
        }

        /* Foto Profil Lingkaran yang Overlapping */
        .profile-avatar-container {
            position: relative;
            width: 160px;
            height: 160px;
            margin-top: -80px; /* Menarik gambar ke atas agar menimpa banner */
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover; /* Mencegah gambar gepeng */
            border: 5px solid #212529; /* Border warna body (dark) */
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Tombol Kamera Kecil */
        .upload-btn-wrapper {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #ffc107;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid #212529;
            transition: all 0.3s;
        }

        .upload-btn-wrapper:hover {
            transform: scale(1.1);
            background: #ffdb58;
        }

        .card-custom {
            background-color: #000000;
            border: 1px solid #333;
            border-radius: 12px;
        }
        
        .form-control-dark {
            background-color: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
        }
        
        .form-control-dark:focus {
            background-color: #222;
            color: #fff;
            border-color: #0d6efd;
            box-shadow: none;
        }
    </style>
</head>
<body class="bg-dark text-white">

    <?php include "../components/navbar.php"; ?>

    <div class="profile-banner"></div>

    <div class="container pb-5">
        <?= $msg ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                
                <div class="col-md-4">
                    <div class="card card-custom shadow text-center p-3 h-100">
                        <div class="profile-avatar-container">
                            <img src="../assets/uploads/<?= $profile_pic ?>" id="previewImg" class="profile-avatar" alt="Foto Profil">
                            
                            <label for="fileInput" class="upload-btn-wrapper" title="Ganti Foto">
                                <i class="bi bi-camera-fill text-dark"></i>
                            </label>
                            <input type="file" name="profile_pic" id="fileInput" class="d-none" accept="image/*" onchange="previewFile()">
                        </div>

                        <div class="card-body mt-2">
                            <h3 class="fw-bold mb-1"><?= $data['full_name'] ?></h3>
                            <p class="text-secondary mb-3"><?= $data['email'] ?></p>
                            
                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                <?= ucfirst(str_replace('_', ' ', $data['role'] ?? 'User')) ?>
                            </span>

                            <hr class="border-secondary my-4">

                            <div class="text-start text-secondary small">
                                <p><i class="bi bi-calendar-check me-2"></i> Bergabung: <?= date('d M Y', strtotime($data['created_at'])) ?></p>
                                <p><i class="bi bi-geo-alt me-2"></i> Status: Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="card card-custom shadow h-100">
                        <div class="card-header bg-transparent border-secondary py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Informasi Pribadi</h5>
                        </div>
                        <div class="card-body p-4">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small">NAMA LENGKAP</label>
                                    <input type="text" name="full_name" class="form-control form-control-dark" value="<?= $data['full_name'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small">NOMOR TELEPON</label>
                                    <input type="text" name="phone_number" class="form-control form-control-dark" value="<?= $data['phone_number'] ?>" placeholder="+62...">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small">EMAIL (Tidak dapat diubah)</label>
                                <input type="text" class="form-control form-control-dark text-muted" value="<?= $data['email'] ?>" readonly disabled>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-secondary small">RINGKASAN DIRI (SUMMARY)</label>
                                <textarea name="summary" class="form-control form-control-dark" rows="6" placeholder="Tuliskan keahlian, pengalaman kerja, atau deskripsi singkat tentang diri Anda..."><?= $data['summary'] ?></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="../index.php" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script Javascript untuk Preview Gambar sebelum di-save
        function previewFile() {
            const preview = document.getElementById('previewImg');
            const file = document.getElementById('fileInput').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result; // Tampilkan gambar yang dipilih
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>