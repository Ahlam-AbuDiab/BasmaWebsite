<?php
include '../dbConnection.php';
if (!isset($_GET['story_id'])) {
    die("No story selected");
}
$story_id = (int) $_GET['story_id'];
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$storyQuery = "SELECT * FROM Stories WHERE id = $story_id LIMIT 1";
$storyResult = mysqli_query($conn, $storyQuery);

if (!$storyResult || mysqli_num_rows($storyResult) == 0) {
    die("Story not found");
}
$story = mysqli_fetch_assoc($storyResult);
$heroesQuery = "SELECT * FROM Story WHERE story_id = $story_id";
if (!empty($search)) {
    $heroesQuery .= " AND (
        heroName LIKE '%$search%' 
        OR title LIKE '%$search%' 
        OR details LIKE '%$search%'
    )";
}
$heroesQuery .= " ORDER BY id DESC";
$heroesResult = mysqli_query($conn, $heroesQuery);
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
    <title><?php echo htmlspecialchars($story['title']); ?></title>
    <style>
    body {
        min-height: 100vh;
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.82), rgba(0, 0, 0, 0.88)),
            url("../assets/images/statics/cover.png") center/cover no-repeat fixed;
        color: white;
    }

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
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                                        href="userCategoryPhotos.php?category=<?php echo urlencode('قصص البقاء'); ?>">ما
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
                        <li class="nav-item ">
                            <a class="nav-link active" href="#">القصص</a>
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
        <a href="userStoriesPage.php" class="btn-back">
            <i class="bi bi-arrow-right"></i>
            العودة لصفحة القصص
        </a>
    </div>
    <div class="page-wrapper">
        <form method="GET" class="search-box d-flex gap-2 mb-4">
            <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                placeholder="🔍 البحث عن بطل أو قصة">
            <button type="submit" class="btn btn-main">بحث</button>
            <a href="groupStoryHeroes.php?story_id=<?php echo $story_id; ?>" class="btn btn-secondary">
                مسح
            </a>
        </form>
        <h1 class="page-title"><?php echo htmlspecialchars($story['title']); ?></h1>
        <div class="page-subtitle">
            <?php echo htmlspecialchars($story['categoryName']); ?> | أبطال المجموعة القصصية
        </div>
        <?php if(mysqli_num_rows($heroesResult) > 0): ?>
        <div class="group-heroes-list">
            <?php while($hero = mysqli_fetch_assoc($heroesResult)): ?>
            <div class="group-hero-card">
                <div class="group-hero-image">
                    <?php if(!empty($hero['image'])): ?>
                    <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>"
                        alt="hero">
                    <?php else: ?>
                    <img src="default-story.jpg" alt="hero">
                    <?php endif; ?>
                </div>
                <div class="group-hero-content">
                    <span class="group-hero-badge">قصة بطل</span>
                    <?php if(!empty($hero['title'])): ?>
                    <h2 class="hero-title"><?php echo htmlspecialchars($hero['title']); ?></h2>
                    <?php endif; ?>
                    <div class="group-hero-name">
                        <?php echo htmlspecialchars($hero['heroName']); ?>
                    </div>
                    <div class="group-hero-details">
                        <?php echo mb_substr(htmlspecialchars($hero['details']), 0, 230); ?>...
                    </div>
                    <a href="userViewHero.php?id=<?php echo $hero['id']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        اقرأ القصة كاملة
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty">
            لا يوجد أبطال مضافون داخل هذه المجموعة القصصية حالياً.
        </div>
        <?php endif; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const heroCards = document.querySelectorAll(".group-hero-card");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.18
        });

        heroCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 120}ms`;
            observer.observe(card);
        });
    });
    </script>
</body>

</html>