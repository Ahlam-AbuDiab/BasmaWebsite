<?php
include '../auth.php'; 
$adminName= isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title> إضافة فيديو جديد</title>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">
        <div class="menu-overlay" id="menuOverlay"></div>
        <div class="container">
            <div class="navbar-left">
                <a class="navbar-brand m-0 me-4" href="#">
                    <img src="../assets/images/logos/basmah.png" alt="logo" height="100" width="150">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-center">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav gap-lg-6 mobile-menu-list">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                من نحن
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="member.php?id=4">أحلام أبو دياب</a></li>
                                <li><a class="dropdown-item" href="member.php?id=5">منى حجازي</a></li>
                                <li><a class="dropdown-item" href="member.php?id=3">نورا عاشور</a></li>
                                <li><a class="dropdown-item" href="member.php?id=2">هدى سلامة</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="adminShareForm.php">شارك معنا</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                الصور
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addPhoto.php">اضافة صورة</a></li>
                                <li><a class="dropdown-item" href="adminPhotoPage.php">عرض الصور</a></li>
                            </ul>
                        </li>

                        <li class="nav-item active">
                            <a class="nav-link active" href="#">
                                الفيديوهات
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addStory.php">اضافة قصة</a></li>
                                <li><a class="dropdown-item" href="adminStoryPage.php">عرض القصص</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminDash.php">الرئيسية</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-right">
                <div class="nav-item dropdown admin-menu">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <span class="admin-name"><?php echo htmlspecialchars($adminName); ?></span>
                        <span class="admin-icon-wrap">
                            <i class="bi bi-person-fill"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="bi bi-person me-2"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="../logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <a href="adminVideoPage.php" class="btn-back">
                    <i class="bi bi-arrow-right"></i>
                    العودة لمعرض الفيديوهات
                </a>
                <h1 class="page-title">إضافة فيديو جديد</h1>
            </div>
            <div class="form-card">
                <form action="../logic/addVideo_logic.php" method="post" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label"> :التصنيف</label>
                            <select name="categoryName" class="form-select" required>
                                <option value="">اختر التصنيف</option>
                                <option value="أصوات من غزة">أصوات من غزة</option>
                                <option value="توثيق ميداني">توثيق ميداني </option>
                                <option value="شهادات حية">شهادات حية</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">: عنوان الفيديو</label>
                            <input type="text" name="title" class="form-control" placeholder="ادخل عنوان الفيديو "
                                required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">: وصف الفيديو</label>
                            <textarea name="details" rows="8" class="form-control" placeholder="اكتب وصف الفيديو كاملة"
                                required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">الفيديو</label>
                            <div class="upload-box">
                                <i class="bi bi-camera-video"></i>
                                <p>اختر الفيديو</p>
                                <input type="file" name="video" class="form-control mt-3" accept="video/*" required>
                            </div>
                        </div>
                        <div class="actions">
                            <button type="submit" name="save_video" class="btn-save">
                                <i class="bi bi-save"></i>
                                حفظ الفيديو
                            </button>
                            <button type="reset" class="btn-reset">
                                إعادة تعيين
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
</body>

</html>