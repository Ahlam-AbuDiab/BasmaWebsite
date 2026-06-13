<?php
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
if(!isset($_GET['category'])){
    die("No category selected");
}
$category = mysqli_real_escape_string($conn, $_GET['category']);
$search = $_GET['search'] ?? '';
$searchSafe = mysqli_real_escape_string($conn, $search);
$query = "SELECT * FROM Photos
          WHERE categoryName = '$category'";
if(!empty($searchSafe)){
    $query .= " AND (title LIKE '%$searchSafe%'
                OR details LIKE '%$searchSafe%'
            )";
}
$query .= " ORDER BY id DESC ";
$result = mysqli_query($conn, $query);
$photos = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $row['imagePath'] = "../uploads/uploadsPhotos/".$row['image'];
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
    <title><?php echo htmlspecialchars($category); ?></title>
    <style>
    .navbar {
        direction: ltr;
    }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 34px;
    }

    .photo-icon-card.active-photo-card {
        background: linear-gradient(135deg, #7a0010, #4a000a) !important;
        border: 2px solid #e63946 !important;
        transform: scale(1.05) !important;
        box-shadow: 0 8px 25px rgba(230, 57, 70, 0.45) !important;
    }

    .photo-icon-card.active-photo-card:hover {
        transform: scale(1.05) translateY(-4px) !important;
        background: linear-gradient(135deg, #920013, #5a000c) !important;
        border-color: #ff4d5a !important;
        box-shadow: 0 10px 30px rgba(230, 57, 70, 0.6) !important;
    }

    .photo-icon-card.active-photo-card h5,
    .photo-icon-card.active-photo-card:hover h5 {
        color: #ffffff !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }

    .photo-icon-card.active-photo-card .category-count {
        background: rgba(0, 0, 0, 0.35) !important;
        color: #ffcccc !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .photo-icon-card.active-photo-card img {
        filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
    }
    </style>
</head>

<body>
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
                            <a class="nav-link  text-white" href="userShareForm.php" role="button">شارك معنا</a>
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
    <div class="page-header">
        <a href="userPhotosPage.php" class="btn-back">
            <i class="bi bi-arrow-right"></i>
            العودة لصفحة الصور
        </a>
    </div>
    <div class="page-wrapper">
        <form method="GET" class="search-box d-flex gap-2">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                placeholder="🔍 البحث عن صورة">
            <button type="submit" class="btn btn-main">بحث</button>
            <a href="userCategoryPhotos.php?category=<?php echo urlencode($category); ?>" class="btn btn-secondary">
                مسح
            </a>
        </form>
        <?php
        $categoryIntro = [
            "سير الشهداء" => "هنا نحفظ صور الشهداء ووجوههم، لا كأرقام عابرة، بل كذاكرة حية لا تُنسى.",
            "قيود الحرية" => "في هذا القسم تُعرض صور توثق القيد والانتظار والوجع الإنساني.",
            "ما بين الحياة والموت" => "صور عن النجاة والتمسك بالحياة رغم الخوف والفقد والدمار.",
            "رحلة النزوح" => "هنا تُعرض صور الرحيل القسري، والبحث عن الأمان بين الطرق والخيام والانتظار.",
            "ما بعد القصف" => "مساحة لصور الدمار وما يبقى بعد القصف من أثر وذاكرة.",
            "صرخات الجوع" => "صور توثق قسوة الجوع ونقص الطعام، وما يتركه ذلك من أثر على العائلات والأطفال."
        ];
        $introText = $categoryIntro[$category] ?? "هنا تجدون مجموعة من الصور الموثقة ضمن هذا التصنيف.";
        ?>
        <div class="category-hero">
            <span>تصنيف الصور</span>
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <p><?php echo htmlspecialchars($introText); ?></p>
        </div>

        <?php if(count($photos) > 0): ?>
        <div class="photos-grid">
            <?php foreach($photos as $index => $row): ?>
            <div class="photo-card" onclick="openLightbox(<?php echo $index; ?>)">
                <div class="photo-img">
                    <span class="photo-number"><?php echo $index + 1; ?></span>
                    <img src="../uploads/uploadsPhotos/<?php echo htmlspecialchars($row['image']); ?>">
                </div>
                <h3 class="photo-title">
                    <?php echo htmlspecialchars($row['title']); ?>
                </h3>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty">لا توجد صور مضافة داخل هذا التصنيف حالياً.</div>
        <?php endif; ?>
    </div>
    <section class="photos-icons-section" id="photos-icons-section">
        <div class="photos-icons-wrap">
            <h2 class="photos-icons-title">استكشف الصور</h2>
            <div class="photos-icons-grid">
                <a class="photo-icon-card <?php echo ($category === 'سير الشهداء') ? 'active-photo-card' : ''; ?>"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('سير الشهداء'); ?>">
                    <img src="../assets/images/icons/martys.png" alt="سير الشهداء">
                    <h5>سير الشهداء</h5>
                    <span class="category-count"><?php echo $categoryCounts['سير الشهداء'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card <?php echo ($category === 'قيود الحرية') ? 'active-photo-card' : ''; ?>"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('قيود الحرية'); ?>">
                    <img src="../assets/images/icons/prisoners.png" alt="قيود الحرية">
                    <h5>قيود الحرية</h5>
                    <span class="category-count"><?php echo $categoryCounts['قيود الحرية'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card <?php echo ($category === 'ما بين الحياة والموت') ? 'active-photo-card' : ''; ?>"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('ما بين الحياة والموت'); ?>">
                    <img src="../assets/images/icons/survivor.png" alt="ما بين الحياة والموت">
                    <h5>ما بين الحياة والموت</h5>
                    <span class="category-count"><?php echo $categoryCounts['ما بين الحياة والموت'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card <?php echo ($category === 'رحلة النزوح') ? 'active-photo-card' : ''; ?>"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('رحلة النزوح'); ?>">
                    <img src="../assets/images/icons/displacment.png" alt="رحلة النزوح">
                    <h5>رحلة النزوح</h5>
                    <span class="category-count"><?php echo $categoryCounts['رحلة النزوح'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card <?php echo ($category === 'صرخات الجوع') ? 'active-photo-card' : ''; ?>"
                    href="userCategoryPhotos.php?category=<?php echo urlencode('صرخات الجوع'); ?>">
                    <img src="../assets/images/icons/famine.png" alt="صرخات الجوع">
                    <h5>صرخات الجوع</h5>
                    <span class="category-count"><?php echo $categoryCounts['صرخات الجوع'] ?? 0; ?> صورة</span>
                </a>
                <a class="photo-icon-card <?php echo ($category === 'ما بعد القصف') ? 'active-photo-card' : ''; ?>"
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
                onerror="../uploads/uploadsPhotos/default.png;">
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
            "title" => $photo["title"] ?? "",
            "details" => $photo["details"] ?? "",
            "image" => $photo["imagePath"] ?? "../uploads/uploadsPhotos/default.png"
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