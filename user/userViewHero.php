<?php
include '../dbConnection.php';
if(!isset($_GET['id'])){
    die("No story selected");
}
$hero_id = (int) $_GET['id'];
$query = "SELECT Story.*, Stories.title AS mainStoryTitle, Stories.categoryName 
          FROM Story 
          INNER JOIN Stories ON Story.story_id = Stories.id
          WHERE Story.id = $hero_id";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) == 0){
    die("Story not found");
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title><?php echo htmlspecialchars($row['heroName']); ?></title>
    <style>
    body {
        min-height: 100vh;
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.84), rgba(0, 0, 0, 0.84)),
            url("../assets/images/statics/cover.png") center/cover no-repeat fixed;
        color: #fff;
    }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="menu-overlay" id="menuOverlay"></div>
        <div class="container">

            <div class="navbar-left">
                <a class="navbar-brand m-0" href="../index.php">
                    <img src="../assets/images/logos/basmah.png" height="100" width="100">
                </a>
            </div>

            <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

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
                            <a class="nav-link active dropdown-toggle text-white" href="#" role="button"
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

    <section class="cover container my-5 pt-4">
        <div class="page-header mb-4">
            <a href="userStoriesPage.php" class="btn btn-outline-light rounded-pill px-4">
                <i class="bi bi-arrow-right me-2"></i>
                العودة لصفحة القصص
            </a>
        </div>

        <div class="hero-layout">

            <div class="hero-image-card">
                <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($row['image']); ?>"
                    alt="hero image" class="popup-image rounded shadow" style="max-width: 100%; height: auto;">
            </div>

            <div class="hero-content-card">
                <span
                    class="story-badge badge bg-danger mb-3 p-2 fs-6"><?php echo htmlspecialchars($row['categoryName']); ?></span>

                <div class="main-story-title mb-2 text-white-50 fs-5">
                    القصة العامة: <?php echo htmlspecialchars($row['mainStoryTitle']); ?>
                </div>

                <?php if (!empty($row['title'])): ?>
                <h1 class="hero-title display-6 fw-bold mb-3"><?php echo htmlspecialchars($row['title']); ?></h1>
                <?php else: ?>
                <h1 class="hero-title display-6 fw-bold mb-3">قصة إنسانية موثقة</h1>
                <?php endif; ?>

                <div class="hero-name h3 text-warning mb-4">
                    <?php echo htmlspecialchars($row['heroName']); ?>
                </div>

                <div class="hero-meta d-flex gap-3 mb-4 text-white-50">
                    <div class="meta-item">
                        <i class="bi bi-bookmark-star me-1"></i>
                        <?php echo ($row['story_type'] === 'single') ? 'قصة فردية' : 'مجموعة قصصية'; ?>
                    </div>

                    <div class="meta-item">
                        <i class="bi bi-folder2-open me-1"></i>
                        <?php echo htmlspecialchars($row['categoryName']); ?>
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <div class="hero-details">
                    <?php 
                        $details = htmlspecialchars($row['details']);
                        $paragraphs = explode("\n", $details);
                        foreach ($paragraphs as $paragraph) {
                            if (trim($paragraph) !== '') {
                                echo "<p class='hero-details-paragraph'>" . nl2br($paragraph) . "</p>";
                            }
                        }
                    ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
</body>

</html>