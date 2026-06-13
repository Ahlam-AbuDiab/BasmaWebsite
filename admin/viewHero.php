<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
if (!isset($_GET['id']) || !isset($_GET['story_id'])) {
    die("Invalid request");
}

$hero_id = (int) $_GET['id'];
$story_id = (int) $_GET['story_id'];

$query = "SELECT Story.*, Stories.title AS mainStoryTitle, Stories.categoryName, Stories.story_type
          FROM Story
          INNER JOIN Stories ON Story.story_id = Stories.id
          WHERE Story.id = $hero_id AND Story.story_id = $story_id
          LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("القصة غير موجودة");
}

$hero = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title><?php echo htmlspecialchars($hero['heroName']); ?></title>
</head>

<body class="be-light">
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

                        <li class="nav-item active">
                            <a class="nav-link active" href="#">القصص</a>
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
    <div class="page-container">
        <a href="storyPersons.php?story_id=<?php echo $story_id; ?>" class="btn-back">
            <i class="bi bi-arrow-right"></i>
            الرجوع إلى قائمة الأبطال
        </a>
        <div class="hero-layout">
            <div class="hero-image-card">
                <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>"
                    alt="hero image">
            </div>
            <div class="hero-content-card">
                <span class="story-badge"><?php echo htmlspecialchars($hero['categoryName']); ?></span>
                <div class="main-story-title">
                    القصة العامة: <?php echo htmlspecialchars($hero['mainStoryTitle']); ?>
                </div>
                <?php if (!empty($hero['title'])): ?>
                <h1 class="hero-title"><?php echo htmlspecialchars($hero['title']); ?></h1>
                <?php else: ?>
                <h1 class="hero-title">قصة إنسانية موثقة</h1>
                <?php endif; ?>
                <div class="hero-name">
                    <?php echo htmlspecialchars($hero['heroName']); ?>
                </div>
                <div class="hero-meta">
                    <div class="meta-item">
                        <i class="bi bi-bookmark-star"></i>
                        <?php echo ($hero['story_type'] === 'single') ? 'قصة فردية' : 'مجموعة قصصية'; ?>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-folder2-open"></i>
                        <?php echo htmlspecialchars($hero['categoryName']); ?>
                    </div>
                </div>
                <div class="hero-details">
                    <?php echo nl2br(htmlspecialchars($hero['details'])); ?>
                </div>
                <div class="action-bar">
                    <a href="updateHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $story_id; ?>"
                        class="action-btn btn-edit">
                        <i class="bi bi-pencil-square"></i>
                        تعديل القصة
                    </a>
                    <a href="deleteHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $story_id; ?>"
                        class="action-btn btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذه القصة؟');">
                        <i class="bi bi-trash3"></i>
                        حذف القصة
                    </a>
                    <a href="storyPersons.php?story_id=<?php echo $story_id; ?>" class="action-btn btn-view">
                        <i class="bi bi-eye"></i>
                        كل أبطال القصة
                    </a>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
</body>

</html>