<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
if(!isset($_GET['story_id'])){
    die('Invalid Id');
}
$story_id = intval($_GET['story_id']);
$storyQuery = "SELECT * FROM Stories WHERE id = $story_id";
$storyResult = mysqli_query($conn, $storyQuery);

if(!$storyResult || mysqli_num_rows($storyResult) == 0){
    die("Story not found");
}
$storyData = mysqli_fetch_assoc($storyResult);
$herosQuery = "SELECT * FROM Story WHERE story_id = $story_id ORDER BY id ASC";
$herosResult = mysqli_query($conn, $herosQuery);
$herosCountQuery = "SELECT COUNT(*) AS total FROM Story WHERE story_id = $story_id";
$herosCountResult = mysqli_query($conn, $herosCountQuery);
$herosCountRow = mysqli_fetch_assoc($herosCountResult);
$herosCount = (int)$herosCountRow['total'];
$canAddHero = true;
if($storyData['story_type'] === 'single' && $herosCount >= 1){
    $canAddHero = false;
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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title><?php echo htmlspecialchars($storyData['title']); ?></title>
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
    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف بطل القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل بطل القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['added'])): ?>
    <div class="alert alert-success custom-alert">تمت إضافة بطل جديد بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['single_full'])): ?>
    <div class="alert alert-warning custom-alert">هذه القصة فردية مخصصة لبطل واحد فقط</div>
    <?php endif; ?>
    <section class="page-wrapper">
        <div class="page-header">
            <div>
                <h1 class="page-title"><?php echo htmlspecialchars($storyData['title']); ?></h1>
                <div class="story-meta">
                    التصنيف: <?php echo htmlspecialchars($storyData['categoryName']); ?>
                </div>
            </div>
            <div class="top-actions">
                <?php if($canAddHero): ?>
                <a href="addHeroStories.php?story_id=<?php echo $storyData['id']; ?>" class="btn-main">
                    <i class="bi bi-plus-circle"></i>
                    إضافة بطل جديد
                </a>
                <?php else: ?>
                <div class="btn-main" style="opacity:0.65; pointer-events:none;">
                    <i class="bi bi-check-circle"></i>
                    تمت إضافة بطل هذه القصة
                </div>
                <?php endif; ?>
                <a href="adminStoryPage.php" class="btn-back">
                    <i class="bi bi-arrow-right"></i>
                    العودة لإدارة القصص
                </a>
            </div>
        </div>
        <?php if(mysqli_num_rows($herosResult) > 0): ?>
        <div class="heroes-sections">
            <?php 
        $index = 0;
        while($hero = mysqli_fetch_assoc($herosResult)): 
            $reverseClass = ($index % 2 != 0) ? 'hero-section reverse' : 'hero-section';
        ?>
            <div class="<?php echo $reverseClass; ?>">
                <div class="hero-section-image">
                    <img src="../uploads/uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>"
                        alt="hero">
                </div>

                <div class="hero-section-content">
                    <span class="hero-badge">قصة بطل</span>

                    <?php if(!empty($hero['title'])): ?>
                    <h2 class="hero-section-title">
                        <?php echo htmlspecialchars($hero['title']); ?>
                    </h2>
                    <?php endif; ?>

                    <h3 class="hero-section-name">
                        <?php echo htmlspecialchars($hero['heroName']); ?>
                    </h3>
                    <div class="hero-section-details" id="storyText">
                        <?php
                    $shortText = mb_substr($hero['details'], 0, 180);
                    if(mb_strlen($hero['details']) > 180){
                        echo nl2br(htmlspecialchars($shortText)) . " …";
                    } else {
                        echo nl2br(htmlspecialchars($shortText));
                    }
                    ?>
                    </div>
                    <a href="viewHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                        class="btn-read">
                        اقرأ القصة كاملة
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="hero-section-actions">
                        <a href="updateHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                            class="btn-edit">
                            <i class="bi bi-pencil-square"></i>
                            تعديل
                        </a>
                        <a href="deleteHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                            class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا البطل؟');">
                            <i class="bi bi-trash3"></i>
                            حذف
                        </a>
                    </div>
                </div>

            </div>
            <?php 
            $index++;
        endwhile; 
        ?>
        </div>
        <?php else: ?>
        <div class="empty-box">
            لا يوجد أبطال مضافون داخل هذه القصة بعد
        </div>
        <?php endif; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/navbar.js"></script>
        <script src="../assets/js/animation.js"></script>
</body>


</html>