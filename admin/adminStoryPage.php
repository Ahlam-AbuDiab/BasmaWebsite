<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$query = "SELECT Stories.*, COUNT(Story.id) As herosCount FROM Stories LEFT JOIN Story ON Stories.id = Story.story_id WHERE 1";
if (!empty($search)) {
    $query .= " AND (Stories.title LIKE '%$search%' OR Stories.description LIKE '%$search%')";
}
if (!empty($category)) {
    $query .= " AND Stories.categoryName = '$category'";
}
$query .= " GROUP BY Stories.id ORDER BY Stories.id ASC";
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
    <title>صفحة عرض القصص</title>
    <style>
    </style>
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
    <?php if(isset($_GET['added'])): ?>
    <div class="alert alert-success custom-alert">تم إضافة القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف القصة بنجاح</div>
    <?php endif; ?>
    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="admin-actions">
                    <a href="addStory.php" class="btn-viewPage">
                        <i class="bi bi-plus-circle"></i>
                        اضافة قصة
                    </a>
                </div>
                <h1 class="page-title"> صفحة عرض و إدارة القصص في موقع بصمة</h1>
            </div>
            <div class="toolbar">
                <form method="GET" class="admin-filter-form">
                    <div class="filter-group">
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">اختر نوع القصة</option>
                            <option value="سير الشهداء"
                                <?php if(isset($_GET['category']) && $_GET['category']=="سير الشهداء") echo "selected"; ?>>
                                سير الشهداء</option>
                            <option value="قيود الحرية"
                                <?php if(isset($_GET['category']) && $_GET['category']=="قيود الحرية") echo "selected"; ?>>
                                قيود الحرية</option>
                            <option value="ما بين الحياة والموت"
                                <?php if(isset($_GET['category']) && $_GET['category']=="ما بين الحياة والموت") echo "selected"; ?>>
                                ما بين الحياة والموت</option>
                            <option value="رحلة النزوح"
                                <?php if(isset($_GET['category']) && $_GET['category']=="رحلة النزوح") echo "selected"; ?>>
                                رحلة النزوح</option>
                            <option value="حكايات الصمود"
                                <?php if(isset($_GET['category']) && $_GET['category']=="حكايات الصمود") echo "selected"; ?>>
                                حكايات الصمود</option>
                            <option value="صرخات الجوع"
                                <?php if(isset($_GET['category']) && $_GET['category']=="صرخات الجوع") echo "selected"; ?>>
                                صرخات الجوع</option>
                        </select>
                    </div>

                    <div class="search-box">
                        <a href="adminStoryPage.php" class="btn btn-secondary">
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
            <div class="table-wrapper">
                <table class="stories-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان القصة</th>
                            <th>التصنيف</th>
                            <th>نوع القصة</th>
                            <th> وصف القصة</th>
                            <th>عدد أبطال القصة</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td>
                                <div class="story-title"><?php echo htmlspecialchars($row['title']); ?></div>
                            </td>
                            <td>
                                <div class="categoryName"><?php echo htmlspecialchars($row['categoryName']); ?></div>
                            </td>
                            <td>
                                <div class="story-type">
                                    <?php
                                        if($row['story_type']=='single'){
                                            echo "قصة فردية";
                                        }else{
                                            echo "مجموعة قصصية";
                                        }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="story-desc"><?php echo htmlspecialchars($row['description']);?></div>
                            </td>
                            <td>
                                <div class="herosCount"><?php echo $row['herosCount'];?> من الأبطال </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="storyPersons.php?story_id=<?php echo $row['id'];?>"
                                        class="action-btn btn-view">
                                        <i class="bi bi-eye"></i>
                                        عرض أبطال القصة
                                    </a>
                                    <a href="updateStory.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                        تعديل
                                    </a>
                                    <a href="deleteStory.php?id=<?php echo $row['id']; ?>" class="action-btn btn-delete"
                                        onclick="return confirm('هل أنت متأكد من حذف القصة؟');">
                                        <i class="bi bi-trash3"></i>
                                        حذف
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        }else{
                        ?>
                        <tr>
                            <td colspan="7">لا توجد قصص مضافة بعد</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/navbar.js"></script>
<script src="../assets/js/animation.js"></script>

</html>