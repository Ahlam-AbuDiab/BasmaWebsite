<?php
include '../dbConnection.php';
$randomQuery = "SELECT Story.id, Story.story_id, Story.heroName, Story.details, Story.image,
                Stories.title AS mainTitle, Stories.categoryName FROM Story INNER JOIN Stories 
                ON Story.story_id = Stories.id ORDER BY RAND() LIMIT 6";
$randomResult = mysqli_query($conn, $randomQuery);
if (!$randomResult) {
    die("Query Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($randomResult) == 0) {
    echo "<p style='color:red;text-align:center'>لا توجد قصص في جدول Story أو الربط مع Stories غير صحيح</p>";
}
$totalStoriesQuery = "SELECT COUNT(*) AS total FROM Stories";
$totalStoriesResult = mysqli_fetch_assoc(mysqli_query($conn, $totalStoriesQuery));
$totalHeroesQuery = "SELECT COUNT(*) AS total FROM Story";
$totalHeroesResult = mysqli_fetch_assoc(mysqli_query($conn, $totalHeroesQuery));
$statsQuery = "SELECT Stories.categoryName, COUNT(Story.id) AS total FROM Stories
                LEFT JOIN Story ON Stories.id = Story.story_id GROUP BY Stories.categoryName
                ORDER BY total DESC";
$statsResult = mysqli_query($conn, $statsQuery); 
$categoryCounts = [];
$countQuery = "SELECT Stories.categoryName, COUNT(Story.id) AS total FROM Stories
                LEFT JOIN Story ON Stories.id = Story.story_id GROUP BY Stories.categoryName";
$countResult = mysqli_query($conn, $countQuery);
while($row = mysqli_fetch_assoc($countResult)){
    $categoryCounts[$row['categoryName']]=$row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <title>صفحة القصص</title>
    <style>
    .stories-grid {
        justify-content: center;
        padding: 40px 20px;
        flex-wrap: wrap;
        display: grid;
        grid-template-columns: repeat(autofit, minmax(3, 1fr));
        gap: 25px;
        align-items: start;
    }

    .story-card {
        width: 100%;
        min-height: 350px;
        overflow: hidden;
        border-radius: 15px;
        position: relative;
        cursor: pointer;
        transition: 0.4s;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.06);
        direction: rtl;
    }

    .story-card:hover {
        transform: translateY(-7px);
        border-color: rgba(230, 57, 70, 0.35);
    }

    .story-card img {
        width: 100%;
        transition: 0.4s;
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #111;
        display: block;
    }

    .story-card-content {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        transform: translateY(50%);
        transition: 0.4s;
        text-align: right;
    }

    .story-card {
        opacity: 0;
        transition: 0.8s ease;
    }

    .story-card:nth-child(odd) {
        transform: translateX(90px) scale(0.96);
    }

    .story-card:nth-child(even) {
        transform: translateX(-90px) scale(0.96);
    }

    .story-card.show {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    .story-card:hover img {
        transform: scale(1.1);
    }

    .story-card:hover .story-card-content {
        transform: translateY(0);
    }

    .story-card-content h5 {
        margin: 0;
        font-size: 20px;
        font-size: 20px;
        font-weight: bold;
    }

    .story-card-content p {
        font-size: 14px;
        color: #ccc;
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
    <section class="hero-slider">
        <div id="storiesSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="slider-bg" style="background-image:url('../assets/images/sliders/slider1.jpg');">
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="slider-bg" style="background-image:url('../assets/images/sliders/storySlider2.png');">
                    </div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>كل قصة هنا تحمل أثراً وصوتاً وصبراً</h1>
                            <p>
                                من النزوح إلى الفقد، ومن البقاء إلى الصمود، نجمع الحكايات التي
                                تعكس التجربة الإنسانية بكل صدقها وعمقها
                            </p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="slider-bg" style="background-image:url('../assets/images/sliders/storySlider3.png');">
                    </div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>ليست القصص كلمات فقط، بل ذاكرة كاملة</h1>
                            <p>
                                هذه الصفحة تجمع وجوهاً وتجارب لا تمرّ كخبر عابر، بل تبقى شاهدة
                                على الحقيقة بما فيها من ألم وصمود وأمل
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#storiesSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#storiesSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section class="section-wrapper">
        <h2 class="section-title">من بين القصص هنا ..... تفاصيل لا تُنسى</h2>
        <div class="stories-grid">
            <?php while($row = mysqli_fetch_assoc($randomResult)): ?>
            <div class="story-card">
                <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($row['image']); ?>" alt="story">
                <div class="story-card-content">
                    <span class="photo-category">
                        <?php echo htmlspecialchars($row['categoryName']); ?>
                    </span>
                    <h5><?php echo htmlspecialchars($row['heroName']); ?></h5>
                    <p>
                        <?php echo mb_substr(htmlspecialchars($row['details']), 0, 120); ?>...
                    </p>
                    <a href="userViewHero.php?id=<?php echo $row['id']; ?>&story_id=<?php echo $row['story_id'];  ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        عرض القصة
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    <section class="stories-icons-section" id="stories-icons-section">
        <div class="stories-icons-wrap">
            <h2 class="stories-icons-title">استكشف القصص</h2>
            <div class="stories-icons-grid">
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('سير الشهداء');?>">
                    <img src="../assets/images/icons/martys.png" alt="سير الشهداء">
                    <h5>سير الشهداء</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['سير الشهداء'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('قيود الحرية');?>">
                    <img src="../assets/images/icons/prisoners.png" alt="قيود الحرية">
                    <h5>قيود الحرية</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['قيود الحرية'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('ما بين الحياة والموت');?>">
                    <img src="../assets/images/icons/survivor.png" alt="ما بين الحياة والموت">
                    <h5>ما بين الحياة والموت</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['ما بين الحياة والموت'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('رحلة النزوح');?>">
                    <img src="../assets/images/icons/displacment.png" alt="رحلة النزوح">
                    <h5>رحلة النزوح</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['رحلة النزوح'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('صرخات الجوع');?>">
                    <img src="../assets/images/icons/famine.png" alt="صرخات الجوع">
                    <h5>صرخات جوع</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['صرخات الجوع'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('حكايات الصمود');?>">
                    <img src="../assets/images/icons/resilience.png" alt="حكايات الصمود">
                    <h5>حكايات صمود</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['حكايات الصمود'] ?? 0; ?> قصة
                    </span>
                </a>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
            }, index * 220);
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-icon-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
                setTimeout(() => {
                    card.style.transform += " scale(1.05)";
                    setTimeout(() => {
                        card.style.transform = "translateY(0) scale(1)";
                    }, 150);
                }, 400);

            }, index * 180);
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/lightbox.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>