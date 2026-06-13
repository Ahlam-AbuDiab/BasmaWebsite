<?php
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
if(!isset($_GET['category'])){
    die("No category selected");
}
$category = mysqli_real_escape_string($conn, $_GET['category']);
$query = "SELECT * FROM Videos 
          WHERE categoryName = '$category'
          ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$videos = [];
$totalVideos = count($videos);
$countResult = mysqli_query($conn, "
    SELECT categoryName, COUNT(*) AS total 
    FROM videos 
    GROUP BY categoryName
");
$categoryCounts = [];
if ($countResult) {
    while ($row = mysqli_fetch_assoc($countResult)) {
        $categoryCounts[$row['categoryName']] = $row['total'];
    }
}
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $row['videoPath'] = "../uploads/uploadsVideos/" . rawurlencode($row['video']);
        $row['posterPath'] = "../uploads/uploadsVideoPosters/" . rawurlencode($row['poster'] ?? '');
        $videos[] = $row;
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

    .video-card {
        width: 100%;
        background: #000;
        cursor: pointer;
        opacity: 0;
        transform: translateY(45px) scale(.95);
        transition: opacity .7s ease, transform .7s ease;
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
                            <a class="nav-link text-white" href="userShareForm.php" role="button">شارك معنا</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الصور</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('سير الشهداء'); ?>">سير
                                        الشهداء</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('قيود الحرية'); ?>">قيود
                                        الحرية</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('ما بين الحياة والموت'); ?>">ما
                                        بين الحياة والموت</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('رحلة النزوح'); ?>">رحلة
                                        النزوح</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('حكايات الصمود'); ?>">حكايات
                                        الصمود</a></li>
                                <li><a class="dropdown-item"
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('صرخات الجوع'); ?>">صرخات
                                        الجوع</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الفيديوهات</a>
                            <ul class="dropdown-menu">
                                <?php
                                $videosCategories = [
                                    "أصوات من غزة",
                                    "توثيق ميداني",
                                    "شهادات حية"
                                ];
                                $activeCategory = $_GET['category'] ?? '';
                                ?>
                                <?php foreach($videosCategories as $cat): ?>
                                <li>
                                    <a class="dropdown-item <?php echo ($activeCategory == $cat) ? 'active' : ''; ?>"
                                        href="userCategoryVideos.php?category=<?php echo urlencode($cat); ?>">
                                        <?php echo $cat; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
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
    <div class="page-wrapper">
        <a href="userVideosPage.php" class="btn-back">
            <i class="bi bi-arrow-right"></i>
            العودة لصفحة الفيديوهات
        </a>
        <?php
            $categoryIntro = [
                    "أصوات من غزة" => "هنا تُعرض أصوات وشهادات تحمل الحقيقة كما عاشها أصحابها.",
                    "توثيق ميداني" => "في هذا القسم تُجمع فيديوهات التوثيق الميداني والمشاهد التي تحفظ الذاكرة.",
                    "شهادات حية" => "هنا تُعرض شهادات حية تنقل الوجع والصمود بالصوت والصورة."
            ];
            $introText = $categoryIntro[$category] ?? "هنا تجدون مجموعة من الفيديوهات الموثقة ضمن هذا التصنيف.";
        ?>
        <div class="category-hero">
            <span>تصنيف الفيديوهات</span>
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <p><?php echo htmlspecialchars($introText); ?></p>
        </div>

        <?php if(count($videos) > 0): ?>
        <div class="videos-grid">
            <?php foreach($videos as $index => $row): ?>
            <div class="video-card" onclick="openLightbox(<?php echo $index; ?>)">
                <div class="video-box">
                    <span class="video-number"><?php echo $index + 1; ?></span>
                    <video muted preload="none" playsinline
                        poster="../uploads/uploadsVideoPosters/<?php echo htmlspecialchars($row['poster']); ?>">
                        <source src="../uploads/uploadsVideos/<?php echo htmlspecialchars($row['video']); ?>"
                            type="video/mp4">
                    </video>

                    <div class="play-layer">
                        <div class="play-box">
                            <i class="bi bi-play-fill"></i>
                        </div>
                    </div>
                </div>

                <h3 class="video-card-title">
                    <?php echo htmlspecialchars($row['title'] ?? 'فيديو'); ?>
                </h3>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty">لا توجد فيديوهات مضافة داخل هذا التصنيف حالياً.</div>
        <?php endif; ?>
    </div>
    <section class="videos-icons-section" id="videos-icons-section">
        <div class="videos-icons-wrap">
            <h2 class="videos-icons-title">استكشف الفيديوهات</h2>

            <div class="videos-icons-grid">
                <a class="video-icon-card <?php echo ($category === 'أصوات من غزة') ? 'active-video-card' : ''; ?>"
                    href="userCategoryVideos.php?category=<?php echo urlencode('أصوات من غزة'); ?>">
                    <img src="../assets/images/icons/voices.png" alt="أصوات من غزة">
                    <h5>أصوات من غزة</h5>
                    <span class="category-count"><?php echo $categoryCounts['أصوات من غزة'] ?? 0; ?> فيديو</span>
                </a>

                <a class="video-icon-card <?php echo ($category === 'توثيق ميداني') ? 'active-video-card' : ''; ?>"
                    href="userCategoryVideos.php?category=<?php echo urlencode('توثيق ميداني'); ?>">
                    <img src="../assets/images/icons/documentation.png" alt="توثيق ميداني">
                    <h5>توثيق ميداني</h5>
                    <span class="category-count"><?php echo $categoryCounts['توثيق ميداني'] ?? 0; ?> فيديو</span>
                </a>

                <a class="video-icon-card <?php echo ($category === 'شهادات حية') ? 'active-video-card' : ''; ?>"
                    href="userCategoryVideos.php?category=<?php echo urlencode('شهادات حية'); ?>">
                    <img src="../assets/images/icons/certificate.png" alt="شهادات حية">
                    <h5>شهادات حية</h5>
                    <span class="category-count"><?php echo $categoryCounts['شهادات حية'] ?? 0; ?> فيديو</span>
                </a>
            </div>
        </div>
    </section>
    <div class="video-lightbox" id="videoLightbox">
        <div class="lightbox-top">
            <div>
                <span class="close-btn" onclick="closeLightbox()">&times;</span>
            </div>
            <div>
                <span class="lightbox-counter" id="lightboxCounter"></span>
            </div>
        </div>
        <div class="lightbox-arrow lightbox-prev" onclick="prevVideo()">
            <i class="bi bi-chevron-right"></i>
        </div>
        <div class="lightbox-view">
            <video src="" id="lightboxVideo" class="lightbox-video" controls autoplay></video>
        </div>

        <div class="lightbox-arrow lightbox-next" onclick="nextVideo()">
            <i class="bi bi-chevron-left"></i>
        </div>
        <div class="lightbox-bottom">
            <div class="thumbs-strip" id="thumbsStrip"></div>
            <div class="lightbox-caption" id="lightboxVideoCaption"></div>
            <div class="lightbox-details" id="lightboxVideoDetails"></div>
        </div>
    </div>
    <div class="video-modal" id="videoModal">
        <div class="video-overlay" onclick="closeVideoModal()"></div>
        <div class="video-modal-content">
            <span class="video-close" onclick="closeVideoModal()">
                <i class="bi bi-x-lg"></i>
            </span>
            <video id="popupVideo" controls autoplay>
                <source src="" type="video/mp4">
            </video>
            <h3 id="videoTitle"></h3>
            <p id="videoDetails"></p>
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
    const videos = <?php
    echo json_encode(array_map(function($video){ 
        return [
            "title" => $video["title"] ?? "فيديو",
            "details" => $video["details"] ?? "",
            "video" => $video["videoPath"] ?? "",
            "poster" => "../uploads/uploadsVideoPosters/" . ($video["poster"] ?? "")
        ];
    }, $videos), JSON_UNESCAPED_UNICODE);
    ?>;
    document.addEventListener("DOMContentLoaded", function() {
        const videoCards = document.querySelectorAll(".video-card");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add("show-video");
                    }, index * 150);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        videoCards.forEach(card => {
            observer.observe(card);
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/videos.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>