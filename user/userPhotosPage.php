<?php
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
$photosQuery = "SELECT * FROM Photos ORDER BY RAND() LIMIT 6";
$photosResult = mysqli_query($conn, $photosQuery);
$photos = [];
if($photosResult){
    while($row = mysqli_fetch_assoc($photosResult)){
        $photos[] = $row;
    }
}
$countQuery = "SELECT categoryName, COUNT(*) AS total FROM photos GROUP BY categoryName";
$countResult = mysqli_query($conn, $countQuery);

$categoryCounts = [];

if($countResult){
    while($row = mysqli_fetch_assoc($countResult)){
        $categoryCounts[$row["categoryName"]] = $row["total"];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>معرض الصور</title>

    <style>
    .navbar {
        direction: ltr;
    }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">
        <div class="menu-overlay" id="menuOverlay"></div>
        <div class="container">
            <div class="navbar-left">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand m-0" href="#">
                        <img src="../assets/images/logos/basmah.png" height="100" width="100">
                    </a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-center">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav gap-4 mobile-menu-list">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">من نحن</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="userMemberView.php?id=4">أحلام أبو دياب</a></li>
                                <li><a class="dropdown-item" href="userMemberView.php?id=5">منى حجازي</a></li>
                                <li><a class="dropdown-item" href="userMemberView.php?id=3">نورا عاشور</a></li>
                                <li><a class="dropdown-item" href="userMemberView.php?id=2">هدى سلامة</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  text-white" href="#" role="button">شارك معنا</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الصور</a>
                            <ul class="dropdown-menu">
                                <?php
                                $photoCategories = [
                                    "سير الشهداء",
                                    "قيود الحرية",
                                    "ما بين الحياة والموت",
                                    "رحلة النزوح",
                                    "حكايات الصمود",
                                    "صرخات الجوع"
                                ];
                                $activeCategory = $_GET['category'] ?? '';
                                ?>
                                <?php foreach($photoCategories as $cat): ?>
                                <li>
                                    <a class="dropdown-item <?php echo ($activeCategory == $cat) ? 'active' : ''; ?>"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode($cat); ?>">
                                        <?php echo $cat; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الفيديوهات</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="userCategoryVideos.php?category=<?php echo urlencode('أصوات من غزة'); ?>">أصوات
                                        من غزة</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryVideos.php?category=<?php echo urlencode('توثيق ميداني'); ?>">توثيق
                                        ميداني</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryVideos.php?category=<?php echo urlencode('شهادات حية'); ?>">شهادات
                                        حية</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('سير الشهداء'); ?>">سير
                                        الشهداء</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('قيود الحرية'); ?>">قيود
                                        الحرية</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('ما بين الحياة والموت'); ?>">ما
                                        بين الحياة والموت</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('رحلة النزوح'); ?>">رحلة
                                        النزوح</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('حكايات الصمود'); ?>">حكايات
                                        الصمود</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryStories.php?category=<?php echo urlencode('صرخات الجوع'); ?>">صرخات
                                        الجوع</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">الرئيسية</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-right">
                <div class="d-flex align-items-center gap-3">
                    <a class="nav-link" id="admin-icon" href="../login.html">
                        <i class="bi bi-person-fill" style="font-size: 30px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero-slider">
        <div id="photosSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#photosSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#photosSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#photosSlider" data-bs-slide-to="2"></button>
            </div>
            <div id="photosSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="slider-bg" style="background-image:url('../assets/images/sliders/slider2.jpg');">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-bg"
                            style="background-image:url('../assets/images/sliders/photoslider1.png');">
                        </div>
                        <div class="hero-content">
                            <div class="hero-text">
                                <h1>هنا تبدأ الصور التي لا يجب أن تُنسى</h1>
                                <p>نوثق الصور كما التقطتها الذاكرة، ونمنح الحقيقة مساحة تبقى فيها الوجوه والأماكن
                                    والتفاصيل
                                    حيّة في الوجدان.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="slider-bg"
                            style="background-image:url('../assets/images/sliders/photoslider3.png');">
                        </div>
                        <div class="hero-content">
                            <div class="hero-text">
                                <h1>ليست الصور مشاهد فقط، بل ذاكرة كاملة</h1>
                                <p>هذه الصفحة تجمع صوراً لا تمرّ كخبر عابر، بل تبقى شاهدة على الحقيقة بما فيها من ألم
                                    وصمود
                                    وأمل.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#photosSlider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#photosSlider" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
    </section>
    <section class="section-wrapper">
        <h2 class="section-title">من بين الصور هنا ..... تفاصيل لا تُنسى</h2>
        <div class="photos-grid">
            <?php if(count($photos) > 0): ?>
            <?php foreach($photos as $index => $row): ?>
            <div class="photo-card" onclick="openLightbox(<?php echo $index; ?>)">
                <img src="../uploads/uploadsPhotos/<?php echo htmlspecialchars($row['image']); ?>">
                <div class="photo-card-content">
                    <span class="category-badge">
                        <?php echo htmlspecialchars($row['categoryName'] ?? 'صورة'); ?>
                    </span>
                    <h5>
                        <?php echo htmlspecialchars($row['title'] ?? ''); ?>
                    </h5>
                    <p>
                        <?php echo htmlspecialchars($row['details'] ?? '', 120); ?>...
                    </p>

                    <button type="button" class="btn-read"
                        onclick="event.stopPropagation(); openLightbox(<?php echo $index; ?>);">
                        عرض الصورة
                        <i class="bi bi-arrows-fullscreen"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p style="color:#111;text-align:center;grid-column:1/-1;">لا توجد صور حالياً</p>
            <?php endif; ?>
        </div>
    </section>
    <section class="photos-icons-section" id="photos-icons-section">
        <div class="photos-icons-wrap">
            <h2 class="photos-icons-title">استكشف الصور</h2>
            <div class="photos-icons-grid">
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('سير الشهداء'); ?>">
                    <img src="../assets/images/icons/martys.png" alt="سير الشهداء">
                    <h5>سير الشهداء</h5>
                    <span class="category-count"><?php echo $categoryCounts['سير الشهداء'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('قيود الحرية'); ?>">
                    <img src="../assets/images/icons/prisoners.png" alt="قيود الحرية">
                    <h5>قيود الحرية</h5>
                    <span class="category-count"><?php echo $categoryCounts['قيود الحرية'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('ما بين الحياة والموت'); ?>">
                    <img src="../assets/images/icons/survivor.png" alt="ما بين الحياة والموت">
                    <h5>ما بين الحياة والموت</h5>
                    <span class="category-count"><?php echo $categoryCounts['ما بين الحياة والموت'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('رحلة النزوح'); ?>">
                    <img src="../assets/images/icons/displacment.png" alt="رحلة النزوح">
                    <h5>رحلة النزوح</h5>
                    <span class="category-count"><?php echo $categoryCounts['رحلة النزوح'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('صرخات الجوع'); ?>">
                    <img src="../assets/images/icons/famine.png" alt="صرخات الجوع">
                    <h5>صرخات الجوع</h5>
                    <span class="category-count"><?php echo $categoryCounts['صرخات الجوع'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('ما بعد القصف'); ?>">
                    <img src="../assets/images/icons/bombing.png" alt="ما بعد القصف">
                    <h5>ما بعد القصف</h5>
                    <span class="category-count"><?php echo $categoryCounts['ما بعد القصف'] ?? 0; ?> صورة</span>
                </a>
            </div>
        </div>
    </section>
    <div class="photo-lightbox" id="photoLightbox">
        <div class="lightbox-backdrop-gallery" id="lightboxBackdropGallery"></div>
        <div class="lightbox-top">
            <div class="lightbox-left-tools">
                <span class="close-btn" onclick="closeLightbox()">&times;</span>
                <i class="bi bi-zoom-in lightbox-tool" onclick="zoomIn()"></i>
                <i class="bi bi-zoom-out lightbox-tool" onclick="zoomOut()"></i>
            </div>
            <div class="lightbox-right-tools">
                <i class="bi bi-grid-3x3-gap lightbox-tool" onclick="toggleThumbs()"></i>
                <span class="lightbox-counter" id="lightboxCounter"></span>
            </div>
        </div>
        <div class="lightbox-arrow lightbox-prev" onclick="prevPhoto()">
            <i class="bi bi-chevron-right"></i>
        </div>
        <div class="lightbox-view">
            <img src="" id="lightboxImage" class="lightbox-image" alt=""
                onerror="this.src='../uploads/uploadsPhotos/default.png';">
        </div>
        <div class="lightbox-arrow lightbox-next" onclick="nextPhoto()">
            <i class="bi bi-chevron-left"></i>
        </div>
        <div class="lightbox-bottom" id="lightboxBottom">
            <div class="thumbs-strip" id="thumbsStrip"></div>
            <div class="lightbox-caption" id="lightboxCaption"></div>
            <div class="lightbox-description" id="lightboxDescription"></div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-right">
            <img src="../assets/images/logos/footer.png" alt="بصمة">
        </div>
        <div class="footer-center">
            <div class="footer-links">
                <a href="../index.php">الرئيسية</a>
                <a href="userStoriesPage.php">القصص</a>
                <a href="userVideosPage.php">الفيديوهات</a>
                <a href="userPhotosPage.php">الصور</a>
                <a href="userShareForm.php">شارك معنا</a>
                <a href="userAboutUs.php">فريق العمل</a>
            </div>
            <div class="footer-contact">
                <a href="https://wa.me/970594148802" target="_blank" class="whatsapp i"><i
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
    <script>
    const photos = <?php
    echo json_encode(array_map(function($photo){
    return [
        "id" => $photo["id"] ?? "",
        "title" => $photo["title"] ?? "",
        "details" => $photo["details"] ?? "",
        "category" => $photo["categoryName"] ?? "",
        "image" => "../uploads/uploadsPhotos/" . ($photo["image"] ?? "default.png")
    ];
    }, $photos), JSON_UNESCAPED_UNICODE);
    ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/lightbox.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>