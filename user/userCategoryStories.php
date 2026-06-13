<?php
include '../dbConnection.php';
if (!isset($_GET['category'])) {
    die("No category selected");
}
$category = mysqli_real_escape_string($conn, $_GET['category']);
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT Stories.*, COUNT(Story.id) AS heroesCount,
                 MIN(Story.id) AS firstHeroId,
                 MIN(Story.image) AS firstHeroImage,
                 MIN(Story.details) AS firstHeroDetails
          FROM Stories 
          LEFT JOIN Story ON Stories.id = Story.story_id
          WHERE Stories.categoryName = '$category'";
if (!empty($search)) {
    $query .= " AND (
        Stories.title LIKE '%$search%' 
        OR Stories.description LIKE '%$search%'
        OR Story.heroName LIKE '%$search%'
        OR Story.details LIKE '%$search%'
    )";
}
$query .= " GROUP BY Stories.id ORDER BY Stories.id DESC";
$result = mysqli_query($conn, $query);
$categoryCounts = [];
$countQuery = "SELECT Stories.categoryName, COUNT(Story.id) AS total FROM Stories
                LEFT JOIN Story ON Stories.id = Story.story_id GROUP BY Stories.categoryName";
$countResult = mysqli_query($conn, $countQuery);
while($row = mysqli_fetch_assoc($countResult)){
    $categoryCounts[$row['categoryName']]=$row['total'];
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

    .categories-stories-grid {
        justify-content: center;
        padding: 40px 20px;
        flex-wrap: wrap;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        align-items: stretch;
    }

    @media (max-width: 991px) {
        .categories-stories-grid {
            grid-template-columns: 1fr;
        }
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
                                <?php
                                $storiesCategories = [
                                    "سير الشهداء",
                                    "قيود الحرية",
                                    "ما بين الحياة والموت",
                                    "رحلة النزوح",
                                    "حكايات الصمود",
                                    "صرخات الجوع"
                                ];
                                $activeCategory = $_GET['category'] ?? '';
                                ?>
                                <?php foreach($storiesCategories as $cat): ?>
                                <li>
                                    <a class="dropdown-item <?php echo ($activeCategory == $cat) ? 'active' : ''; ?>"
                                        href="userCategoryStories.php?category=<?php echo urlencode($cat); ?>">
                                        <?php echo $cat; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
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
                    <a class="nav-link" id="admin-icon" href="login.html">
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
        <form method="GET" class="search-box d-flex gap-2">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                placeholder="🔍 البحث عن قصة">
            <button type="submit" class="btn btn-main">بحث</button>
            <a href="userCategoryStories.php?category=<?php echo urlencode($category); ?>" class="btn btn-secondary">
                مسح
            </a>
        </form>

        <?php
        $categoryIntro = [
            "سير الشهداء" => "هنا نحفظ أسماء الشهداء وحكاياتهم، لا كأرقام عابرة، بل كأرواح تركت أثراً لا يمحى.",
            "قيود الحرية" => "في هذا القسم تُروى حكايات الوجع الإنساني، حيث تختبئ خلف كل قصة معاناة وصبر وذاكرة لا تنسى.",
            "ما بين الحياة والموت" => "قصص عن النجاة والتمسك بالحياة، رغم الخوف والفقد والدمار.",
            "رحلة النزوح" => "هنا تُروى تفاصيل الرحيل القسري، والبحث عن الأمان بين الطرق والخيام والانتظار.",
            "حكايات الصمود" => "مساحة لحكايات الثبات، حيث يصبح الصبر مقاومة، وتصبح الحياة نفسها شكلاً من أشكال القوة.",
            "صرخات الجوع" => "قصص توثق قسوة الجوع ونقص الطعام، وما يتركه ذلك من أثر على العائلات والأطفال."
        ];
        $introText = $categoryIntro[$category] ?? "هنا تجدون مجموعة من القصص الإنسانية الموثقة ضمن هذا التصنيف.";
        ?>
        <div class="category-hero">
            <span>تصنيف القصص</span>
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <p><?php echo htmlspecialchars($introText); ?></p>
        </div>
        <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="categories-stories-grid ">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="category-story-card">
                <?php if($row['story_type'] == 'single'): ?>

                <?php if(!empty($row['firstHeroImage'])): ?>
                <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($row['firstHeroImage']); ?>"
                    alt="story">
                <?php else: ?>
                <div class="single-placeholder">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <?php endif; ?>

                <?php else: ?>

                <div class="group-story-cover">
                    <i class="bi bi-people-fill"></i>
                    <h4>مجموعة قصصية</h4>
                    <p><?php echo $row['heroesCount']; ?> أبطال داخل هذه القصة</p>
                </div>

                <?php endif; ?>
                <div class="story-content">
                    <span class="category-badge">
                        <?php echo htmlspecialchars($row['categoryName']); ?>
                    </span>
                    <span class="<?php echo ($row['story_type'] == 'single') ? 'type-single' : 'type-group'; ?>">
                        <?php echo ($row['story_type'] == 'single') ? 'قصة فردية' : 'مجموعة قصصية'; ?>
                    </span>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>
                        <?php
                if(!empty($row['description'])){
                    echo mb_substr(htmlspecialchars($row['description']), 0, 140) . "...";
                } elseif(!empty($row['firstHeroDetails'])){
                    echo mb_substr(htmlspecialchars($row['firstHeroDetails']), 0, 140) . "...";
                } else {
                    echo "لا يوجد وصف متاح لهذه القصة.";
                }
                ?>
                    </p>
                    <?php if($row['story_type'] == 'single'): ?>
                    <a href="userViewHero.php?id=<?php echo $row['firstHeroId']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        عرض القصة كاملة
                    </a>
                    <?php else: ?>
                    <a href="groupStoryHeroes.php?story_id=<?php echo $row['id']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-view">
                        عرض أبطال القصة
                        <span>(<?php echo $row['heroesCount']; ?>)</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty">
            لا توجد قصص مضافة داخل هذا التصنيف حالياً.
        </div>
        <?php endif; ?>
    </div>
    <section class="stories-icons-section" id="stories-icons-section">
        <div class="stories-icons-wrap">
            <h2 class="stories-icons-title">استكشف القصص</h2>
            <div class="stories-icons-grid">
                <a class="story-icon-card <?php echo ($category === 'سير الشهداء') ? 'active-story-card' : ''; ?>"
                    href="userCategoryStories.php?category=<?php echo urlencode('سير الشهداء');?>">
                    <img src="../assets/images/icons/martys.png" alt="سير الشهداء">
                    <h5>سير الشهداء</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['سير الشهداء'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card <?php echo ($category === 'قيود الحرية') ? 'active-story-card' : ''; ?>"
                    href="userCategoryStories.php?category=<?php echo urlencode('قيود الحرية');?>">
                    <img src="../assets/images/icons/prisoners.png" alt="قيود الحرية">
                    <h5>قيود الحرية</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['قيود الحرية'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card <?php echo ($category === 'ما بين الحياة والموت') ? 'active-story-card' : ''; ?>"
                    href="userCategoryStories.php?category=<?php echo urlencode('ما بين الحياة والموت');?>">
                    <img src="../assets/images/icons/survivor.png" alt="ما بين الحياة والموت">
                    <h5>ما بين الحياة والموت</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['ما بين الحياة والموت'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card <?php echo ($category === 'رحلة النزوح') ? 'active-story-card' : ''; ?>"
                    href="userCategoryStories.php?category=<?php echo urlencode('رحلة النزوح');?>">
                    <img src="../assets/images/icons/displacment.png" alt="رحلة النزوح">
                    <h5>رحلة النزوح</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['رحلة النزوح'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card <?php echo ($category === 'صرخات الجوع') ? 'active-story-card' : ''; ?>"
                    href="userCategoryStories.php?category=<?php echo urlencode('صرخات الجوع');?>">
                    <img src="../assets/images/icons/famine.png" alt="صرخات الجوع">
                    <h5>صرخات جوع</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['صرخات الجوع'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card <?php echo ($category === 'حكايات الصمود') ? 'active-story-card' : ''; ?>"
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
        const cards = document.querySelectorAll(".category-story-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
            }, index * 220);
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>