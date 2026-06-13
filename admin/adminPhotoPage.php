<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$query = "SELECT * FROM Photos WHERE 1";
if (!empty($search)) {
    $query .= " AND (title LIKE '%$search%' OR details LIKE '%$search%')";
}
if (!empty($category)) {
    $query .= " AND categoryName = '$category'";
}
$query .= " ORDER BY id ASC";
$result = mysqli_query($conn, $query);
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
    <title>معرض الصور</title>
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
                        <li class="nav-item">
                            <a class="nav-link active" href="#" r>
                                الصور
                            </a>
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
    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل الصورة بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف الصورة بنجاح</div>
    <?php endif; ?>

    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="admin-actions">
                    <a href="addPhoto.php" class="btn-viewPage">
                        <i class="bi bi-plus-circle"></i>
                        اضافة صورة
                    </a>
                </div>

                <h1 class="page-title"> صفحة معرض الصور في موقع بصمة</h1>
            </div>

            <div class="toolbar">
                <form method="GET" class="admin-filter-form">
                    <div class="filter-group">
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">اختر نوع الصور</option>
                            <option value="سير الشهداء" <?php if($category == "سير الشهداء") echo "selected";?>>سير
                                الشهداء</option>
                            <option value="قيود الحرية" <?php if($category == "قيود الحرية") echo "selected";?>>قيود
                                الحرية</option>
                            <option value="ما بين الحياة والموت"
                                <?php if($category == "ما بين الحياة والموت") echo "selected";?>>ما بين الحياة والموت
                            </option>
                            <option value="رحلة النزوح" <?php if($category == "رحلة النزوح") echo "selected";?>>رحلة
                                النزوح</option>
                            <option value="ما بعد القصف" <?php if($category == "ما بعد القصف") echo "selected";?>>ما بعد
                                القصف</option>
                            <option value="صرخات الجوع" <?php if($category == "صرخات الجوع") echo "selected";?>>صرخات
                                الجوع</option>
                        </select>
                    </div>
                    <div class="search-box">
                        <a href="adminPhotoPage.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i>
                            مسح
                        </a>
                        <button type="submit" class="btn-main">
                            <i class="bi bi-search"></i>
                            بحث
                        </button>
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search);?>"
                            placeholder="🔍 بحث">
                    </div>
                </form>
            </div>

            <div class="photos-grid">
                <?php
            $counter = 1;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <div class="photo-card">
                    <div class="photo-image-box">
                        <span class="photo-number"><?php echo $counter++; ?></span>
                        <a href="viewPhoto.php?id=<?php echo $row ['id'];?>">
                            <img src="../uploads/uploadsPhotos/<?php echo htmlspecialchars($row['image']); ?>"
                                alt="photo">
                        </a>
                        <div class="photo-overlay">
                            <div class="overlay-actions">
                                <a href="updatePhoto.php?id=<?php echo $row['id']; ?>" class="btn-overlay-edit">
                                    <i class="bi bi-pencil-square"></i>
                                    تعديل
                                </a>
                                <a href="deletePhoto.php?id=<?php echo $row['id']; ?>" class="btn-overlay-delete"
                                    onclick="return confirm('هل أنت متأكد من حذف الصورة؟');">
                                    <i class="bi bi-trash3"></i>
                                    حذف
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="photo-content">
                        <div class="photo-title"><?php echo htmlspecialchars($row['title']); ?></div>
                        <div class="photo-desc"><?php echo htmlspecialchars($row['details']); ?></div>
                        <div class="photo-category"><?php echo htmlspecialchars($row['categoryName']); ?></div>
                    </div>
                </div>
                <?php
                }
            }else{
            ?>
                <div class="empty-box w-100">
                    لا توجد صور مضافة بعد
                </div>
                <?php
            }
            ?>
            </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>