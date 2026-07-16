<?php
include 'dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
$storiesCount = 0;
$photosCount = 0;
$videosCount = 0;
$q1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Story");
if($q1){ $storiesCount = mysqli_fetch_assoc($q1)['total']; }
$q2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Photos");
if($q2){ $photosCount = mysqli_fetch_assoc($q2)['total']; }
$q3 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Videos");
if($q3){ $videosCount = mysqli_fetch_assoc($q3)['total']; }
$stories = mysqli_query($conn, "SELECT Story.id, Story.heroName, Story.details, Story.image, Stories.title FROM Story INNER JOIN Stories ON Story.story_id = Stories.id ORDER BY RAND() LIMIT 3");
$photosResult = mysqli_query($conn, "SELECT * FROM Photos ORDER BY RAND() LIMIT 3");
$photos = [];
if($photosResult){
    while($photoRow = mysqli_fetch_assoc($photosResult)){
        $photos[] = $photoRow;
    }
}$video = mysqli_query($conn, "SELECT * FROM Videos ORDER BY RAND() LIMIT 1");
$randomVideo = $video ? mysqli_fetch_assoc($video) : null;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="iccon.png">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <title>الصفحة الرئيسية</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">
        <div class="menu-overlay" id="menuOverlay"></div>
        <div class="container">
            <div class="navbar-right">
                <div class="d-flex align-items-center gap-3">
                    <a class="nav-link" id="admin-icon" href="login.html">
                        <i class="bi bi-person-fill" style="font-size: 30px;"></i>
                    </a>
                </div>
            </div>
            <div class="navbar-center">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav gap-4 mobile-menu-list">
                        <li class="nav-item">
                            <a class="nav-link active" href="../index.php">الرئيسية</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('سير الشهداء'); ?>">سير
                                        الشهداء</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('قيود الحرية'); ?>">قيود
                                        الحرية</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('ما بين الحياة والموت'); ?>">ما
                                        بين الحياة والموت</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('رحلة النزوح'); ?>">رحلة
                                        النزوح</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('حكايات الصمود'); ?>">حكايات
                                        الصمود</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryStories.php?category=<?php echo urlencode('صرخات الجوع'); ?>">صرخات
                                        الجوع</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الفيديوهات</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="user/userCategoryVideos.php?category=<?php echo urlencode('أصوات من غزة'); ?>">أصوات
                                        من غزة</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryVideos.php?category=<?php echo urlencode('توثيق ميداني'); ?>">توثيق
                                        ميداني</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryVideos.php?category=<?php echo urlencode('شهادات حية'); ?>">شهادات
                                        حية</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">الصور</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('سير الشهداء'); ?>">سير
                                        الشهداء</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('قيود الحرية'); ?>">قيود
                                        الحرية</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('قصص البقاء'); ?>">ما
                                        بين الحياة والموت</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('رحلة النزوح'); ?>">رحلة
                                        النزوح</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('حكايات الصمود'); ?>">حكايات
                                        الصمود</a></li>
                                <li><a class="dropdown-item"
                                        href="user/userCategoryPhotos.php?category=<?php echo urlencode('صرخات الجوع'); ?>">صرخات
                                        الجوع</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userShareForm.php" role="button">شارك معنا</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">من نحن</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="user/userMemberView.php?id=4">أحلام أبو دياب</a></li>
                                <li><a class="dropdown-item" href="user/userMemberView.php?id=5">منى حجازي</a></li>
                                <li><a class="dropdown-item" href="user/userMemberView.php?id=3">نورا عاشور</a></li>
                                <li><a class="dropdown-item" href="user/userMemberView.php?id=2">هدى سلامة</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-left">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand m-0" href="#">
                        <img src="assets/images/logos/basmah.png" height="100" width="100">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
    <div class="main-wrapper">
        <section class="hero-section">
            <div class="hero-media">
                <video src="assets/images/statics/FinalVideo.mp4" controls autoplay muted loop playisinline
                    type="video/mp4">المتصفح لا
                    يدعم تشغيل الفيديو</video>
            </div>
            <div class="hero-textDash">
                <h1>َبَصْمَة لَيْسَت مُجَرَّدَ مَوْقِعٍ...<br>َبَلْ مَسَاحَةٌ لِتَوْثِيقِ القِصَصِ كَمَا عَاشَهَا
                    أَصْحَابُهَا...<br>هُنَا لِكُلِّ صُورَةٍ قِصَّةٌ...<br> وَلِكُلِّ فِيدْيُو حِكَايَةٌ...<br>وَلِكُلِّ
                    كَلِمَةٍ أَثَرٌ لَا يُمْحَى...
                </h1>
                <p>
                    وراء هذه الفكرة... قلوب آمنت أن الذاكرة مقاومة، وأن لكل إنسان قصة تستحق أن تُسمع........
                </p>
                <div class="hero-actions">
                    <a href="user/userAboutUs.php" class="main">
                        <i class="bi bi-people-fill"></i>
                        فريق العمل
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <a href="#">
                        مشاهدة الموقع
                        <i class="bi bi-play-circle"></i>
                    </a>
                </div>
            </div>
        </section>
        <section class="stats-ticker">
            <div class="ticker-track">
                <div class="ticker-content">
                    <span><b class="counter" data-target="<?php echo $storiesCount; ?>">0</b> قصة موثقة</span>
                    <span><b class="counter" data-target="<?php echo $photosCount; ?>">0</b> صورة في الأرشيف</span>
                    <span><b class="counter" data-target="<?php echo $videosCount; ?>">0</b> فيديو شاهد</span>
                    <span>تحديثات يومية</span>
                </div>
                <div class="ticker-content">
                    <span>قصة موثقة<b><?php echo $storiesCount; ?></b></span>
                    <span>صورة في الأرشيف<b><?php echo $photosCount; ?></b></span>
                    <span>فيديو شاهد<b><?php echo $videosCount; ?></b></span>
                    <span>تحديثات يومية</span>
                </div>
            </div>
        </section>
        <section class="section-block">
            <div class="section-header">
                <h2>STORIES / القصص</h2>
                <a href="user/userStoriesPage.php">
                    <img src="assets/images/icons/storyLogo.png" alt="logo" height="50px" width="50px">
                    مشاهدة كافة القصص</a>
            </div>
            <div class=" cards-grid">
                <?php if($stories && mysqli_num_rows($stories) > 0): ?>
                <?php while($story = mysqli_fetch_assoc($stories)): ?>
                <div class="storyIndex-card">
                    <img src="uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($story['image']); ?>" alt="">
                    <div class="story-content">
                        <small>قصة موثقة</small>
                        <h3><?php echo htmlspecialchars($story['heroName']); ?></h3>
                        <h4 class="heroStory-title"><?php echo htmlspecialchars($story['title']); ?></h4>
                        <p>
                            <?php echo mb_substr(htmlspecialchars($story['details']), 0, 110); ?>...
                        </p>
                        <a href="user/userViewHero.php?id=<?php echo $story['id']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                            class="btn-read">
                            قراءة القصة
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p>لا توجد قصص حالياً.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="section-block">
            <div class="section-header">
                <h2>VISUAL WITNESS / الشهادة المرئية</h2>
                <div>
                    <a href="user/userVideosPage.php">
                        <img src="assets/images/icons/videologo.png" alt="logo" height="50px" width="50px">
                    </a>
                    <a href="user/userPhotosPage.php">
                        <img src="assets/images/icons/photoLogo.png" alt="logo" height="50px" width="50px">
                    </a>
                    عرض الشهادة المرئية
                </div>
            </div>
            <div class="visual-grid">
                <div class="photo-mosaic">
                    <?php if(count($photos) > 0): ?>
                    <?php foreach($photos as $index => $photo): ?>
                    <div class="visual-photo-card" onclick="openLightbox(<?php echo $index; ?>)">
                        <img src="uploads/uploadsPhotos/<?php echo htmlspecialchars($photo['image']); ?>" alt="">
                        <div class="visual-photo-content">
                            <h3><?php echo htmlspecialchars($photo['title']); ?></h3>
                            <p>
                                <?php echo mb_substr(htmlspecialchars($photo['details'] ?? ''), 0, 80); ?>...
                            </p>
                            <button type="button" class="btn-read"
                                onclick="event.stopPropagation(); openLightbox(<?php echo $index; ?>);">
                                <i class="bi bi-arrows-fullscreen"></i>
                                عرض الصورة كاملة
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if($randomVideo): ?>
                <div class="video-box"
                    onclick="openVideoModal('uploads/uploadsVideos/<?php echo htmlspecialchars($randomVideo['video']); ?>','<?php echo htmlspecialchars($randomVideo['title']); ?>','<?php echo htmlspecialchars($randomVideo['details']); ?>')">
                    <video muted preload="none" playsinline
                        poster="uploads/uploadsVideoPosters/<?php echo htmlspecialchars($randomVideo['poster']); ?>">
                        <source src="uploads/uploadsVideos/<?php echo htmlspecialchars($randomVideo['video']); ?>"
                            type="video/mp4">
                    </video>

                    <div class="play-layer">
                        <i class="bi bi-play-fill"></i>
                    </div>

                    <div class="video-title">
                        <?php echo htmlspecialchars($randomVideo['title']); ?>
                    </div>
                </div>

                <?php else: ?>

                <div class="video-box">
                    <i class="bi bi-camera-video"></i>
                    <div class="video-title">لا يوجد فيديو حالياً</div>
                </div>

                <?php endif; ?>
            </div>
        </section>
        <section class="section-block">
            <div class="share-box">
                <a href="user/userShareForm.php" class="share-btn">
                    <img src="assets/images/icons/form.png" alt="logo" height="50px" width="50px">
                    شارك معنا</a>

                <div>
                    <h2>SHARE YOUR STORY / شارك قصتك</h2>
                    <p>
                        كل قصة من الشهادة هي لبنة في جدار الذاكرة.
                        إذا كان لديك قصة، صورة، أو فيديو يوثق تجربة إنسانية في غزة،
                        يمكنك مشاركتها ليتم مراجعتها وإضافتها للأرشيف.
                    </p>
                </div>
            </div>
        </section>
    </div>
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
            <img src="" id="lightboxImage" class="lightbox-image" alt="" onerror="">
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
    <div class="video-modal" id="videoModal">
        <div>
            <span class="close-btn" onclick="closeLightbox()">&times;</span>
        </div>
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
            <img src="assets/images/logos/footer.png" alt="بصمة">
        </div>
        <div class="footer-center">
            <div class="footer-links">
                <a href="#">الرئيسية</a>
                <a href="user/userStoriesPage.php">القصص</a>
                <a href="user/userVideosPage.php">الفيديوهات</a>
                <a href="user/userPhotosPage.php">الصور</a>
                <a href="user/userShareForm.php">شارك معنا</a>
                <a href="user/userAboutUs.php">فريق العمل</a>
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
    const photos = <?php echo json_encode(array_map(function($photo){
        return [
            "id" => $photo["id"] ?? "",
            "title" => $photo["title"] ?? "",
            "details" => $photo["details"] ?? "",
            "category" => $photo["categoryName"] ?? "",
            "image" => "uploads/uploadsPhotos/" . ($photo["image"] ?? "")
        ];
    }, $photos), JSON_UNESCAPED_UNICODE);
    ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/dashLightbox.js"></script>
    <script src="assets/js/animation.js"></script>
</body>

</html>