<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$photosCount = 0 ;
$videosCount = 0 ;
$storiesCount = 0 ;
$membersCount = 0 ;
$photosQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Photos");
if($photosQuery){
    $photosData = mysqli_fetch_assoc($photosQuery);
    $photosCount = $photosData['total'];
}
$videosQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Videos");
if($videosQuery){
    $videosData = mysqli_fetch_assoc($videosQuery);
    $videosCount = $videosData['total'];
}
$storiesQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Story");
if($storiesQuery){
    $storiesData = mysqli_fetch_assoc($storiesQuery);
    $storiesCount = $storiesData['total'];
}
$membersQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM team");
if($membersQuery){
    $membersData = mysqli_fetch_assoc($membersQuery);
    $membersCount = $membersData['total'];
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>الصفحة الرئيسية</title>
</head>

<body>
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

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                الفيديوهات
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addVideo.php">اضافة فيديو</a></li>
                                <li><a class="dropdown-item" href="adminVideoPage.php">عرض الفيديوهات</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addStory.php">اضافة قصة</a></li>
                                <li><a class="dropdown-item" href="adminStoryPage.php">عرض القصص</a></li>
                            </ul>
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
    <section class="hero-slider">
        <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="slider-bg" style="background-image: url('../assets/images/sliders/slider1.jpg');"></div>
                </div>
                <div class="carousel-item">
                    <div class="slider-bg" style="background-image: url('../assets/images/sliders/slider2.jpg');"></div>
                </div>
                <div class="carousel-item">
                    <div class="slider-bg" style="background-image: url('../assets/images/sliders/slider3.jpg');"></div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section class="admin-sections">
        <div class="admin-grid">
            <div class="admin-card">
                <i> <img src="../assets/images/icons/editStory.png" alt="logo"></i>
                <h3>القصص</h3>
                <p><?php echo $storiesCount; ?> قصة مضافة</p>
                <div class="admin-actions">
                    <a href="addStory.php" class="btn-addPage">إضافة قصة</a>
                    <a href="adminStoryPage.php" class="btn-viewPage">عرض القصص</a>
                </div>
            </div>
            <div class="admin-card">
                <i><img src="../assets/images/icons/editVideo.png" alt="logo"></i>
                <h3>الفيديوهات</h3>
                <p><?php echo $videosCount; ?> فيديو مضاف</p>
                <div class="admin-actions">
                    <a href="addVideo.php" class="btn-addPage">إضافة فيديو</a>
                    <a href="adminVideoPage.php" class="btn-viewPage">عرض الفيديوهات</a>
                </div>
            </div>
            <div class="admin-card">
                <i><img src="../assets/images/icons/editPhoto.png" alt="logo"></i>
                <h3>الصور</h3>
                <p><?php echo $photosCount; ?> صورة مضافة</p>
                <div class="admin-actions">
                    <a href="addPhoto.php" class="btn-addPage">إضافة صورة</a>
                    <a href="adminPhotoPage.php" class="btn-viewPage">عرض الصور</a>
                </div>
            </div>
        </div>
        <div class="admin-grid2">
            <div class="admin-card">
                <i><img src="../assets/images/icons/editForm.png" alt="logo"></i>
                <h3>شارك معنا</h3>
                <p>إدارة فورم المشاركة</p>
                <div class="admin-actions">
                    <a href="adminShareForm.php" class="btn-viewPage">إدارة الفورم</a>
                </div>
            </div>
            <div class="admin-card">
                <i> <img src="../assets/images/icons/editAbout.png" alt="logo"></i>
                <h3>فريق العمل</h3>
                <p><?php echo $membersCount; ?> عضو</p>
                <div class="admin-actions">
                    <a href="addMember.php" class="btn-addPage">إضافة عضو</a>
                    <a href="adminTeamPage.php" class="btn-viewPage">عرض الفريق</a>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="footer-right">
            <img src="../assets/images/logos/footer.png" alt="بصمة">
        </div>
        <div class="footer-center">
            <div class="footer-links">
                <a href="adminDash.php">الرئيسية</a>
                <a href="adminStoryPage.php">القصص</a>
                <a href="adminVideoPage.php">الفيديوهات</a>
                <a href="adminPhotoPage.php">الصور</a>
                <a href="adminShareForm.php">شارك معنا</a>
            </div>
            <div class="footer-contact">
                <a href="https://wa.me/972594148802" target="_blank" class="whatsapp i"><i
                        class="bi bi-whatsapp"></i></a>
                <a href="tel:0594148802" class="phone i"><i class="bi bi-telephone-fill"></i></a>
            </div>
            <div class="footer-copy">
                © 2026 بصمة — جميع الحقوق محفوظة
            </div>
        </div>
        <div class="footer-brand">
            <h5>
                ب<span>ص</span>م<span>ة</span>
            </h5>
            <p>
                أرشيف رقمي يوثق القصص والصور والفيديوهات الإنسانية من غزة.
            </p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
</body>

</html>