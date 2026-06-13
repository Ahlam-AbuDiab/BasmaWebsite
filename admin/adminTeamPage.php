<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$query = "SELECT * FROM team ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!doctype html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title> فريق العمل</title>
</head>

<body class="bg-light">
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

                        <li class="nav-item active">
                            <a class="nav-link active" href="#">
                                من نحن
                            </a>
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

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addStory.php">اضافة قصة</a></li>
                                <li><a class="dropdown-item" href="adminStoryPage.php">عرض القصص</a></li>
                            </ul>
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
    <?php if(isset($_GET['added'])): ?>
    <div class="alert alert-success custom-alert">تم إضافة العضو بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل العضو بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف العضو بنجاح</div>
    <?php endif; ?>

    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="top-actions">
                    <a href="addMember.php" class="btn-main">
                        <i class="bi bi-plus-circle"></i>
                        اضافة عضو جديد
                    </a>
                </div>
                <h1 class="page-title"> صفحة فريق العمل في موقع بصمة</h1>
            </div>

            <div class="team-list">
                <?php if(mysqli_num_rows($result) > 0){ ?>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="member-row">
                    <div class="member-story-box">
                        <p class="member-story">
                            <?php
                                $shortStory = mb_substr($row['story'], 0, 160);
                                echo nl2br(htmlspecialchars($shortStory));
                                if(mb_strlen($row['story']) > 160){
                                    echo "...";
                                }
                                ?>
                        </p>

                        <div class="member-actions">
                            <a href="member.php?id=<?php echo $row['id']; ?>" class="action-btn btn-view">
                                <i class="bi bi-eye"></i>
                                قراءة المزيد
                            </a>

                            <a href="updateMember.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit">
                                <i class="bi bi-pencil-square"></i>
                                تعديل
                            </a>

                            <a href="deleteMember.phps?id=<?php echo $row['id']; ?>" class="action-btn btn-delete"
                                onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟');">
                                <i class="bi bi-trash3"></i>
                                حذف
                            </a>
                        </div>
                    </div>

                    <div class="member-side">
                        <img src="../uploads/uploadsTeamPhotos/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="memberImage" class="member-image">

                        <div class="member-name">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </div>

                        <div class="member-role">
                            <?php echo htmlspecialchars($row['role']); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } else { ?>
                <div class="empty-box">
                    لا يوجد أعضاء مضافون بعد للفريق
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>