<?php
include '../auth.php'; 
include '../dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
mysqli_set_charset($conn, "utf8mb4");
if (isset($_POST['add_question'])) {
    $question_text = mysqli_real_escape_string($conn, $_POST['question_text']);
    $question_type = mysqli_real_escape_string($conn, $_POST['question_type']);
    $options = mysqli_real_escape_string($conn, $_POST['options'] ?? '');
    $is_required = isset($_POST['is_required']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $question_order = (int) $_POST['question_order'];
    $insert = "INSERT INTO share_form_question 
    (question_text, question_type, options, is_required, is_active, question_order)
    VALUES 
    ('$question_text', '$question_type', '$options', $is_required, $is_active, $question_order)";

    mysqli_query($conn, $insert);
    header("Location: adminShareForm.php");
    exit;
}
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM share_form_question WHERE id = $id");
    header("Location: adminShareForm.php?msg=deleted");
    exit;
}
if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    mysqli_query($conn, "UPDATE share_form_question SET is_active = IF(is_active=1, 0, 1) WHERE id = $id");
    header("Location: adminShareForm.php?msg=toggled");
    exit;
}
$editQuestion = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM share_form_question WHERE id = $id LIMIT 1");
    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editQuestion = mysqli_fetch_assoc($editResult);
    }
}
if (isset($_POST['update_question'])) {
    $id = (int) $_POST['id'];
    $question_text = mysqli_real_escape_string($conn, $_POST['question_text']);
    $question_type = mysqli_real_escape_string($conn, $_POST['question_type']);
    $options = mysqli_real_escape_string($conn, $_POST['options'] ?? '');
    $is_required = isset($_POST['is_required']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $question_order = (int) $_POST['question_order'];
    $update = "UPDATE share_form_question SET
        question_text = '$question_text',
        question_type = '$question_type',
        options = '$options',
        is_required = $is_required,
        is_active = $is_active,
        question_order = $question_order
        WHERE id = $id";
    mysqli_query($conn, $update);
    header("Location: adminShareForm.php");
    exit;
}
$questions = mysqli_query($conn, "SELECT * FROM share_form_question ORDER BY question_order ASC, id ASC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>إدارة فورم المشاركة</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.50), rgba(0, 0, 0, 0.50)),
            url("cover.png") center/cover no-repeat fixed;
        color: white;
    }

    .navbar {
        direction: ltr;
    }
    </style>
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
                        <li class="nav-item active">
                            <a class="nav-link active" href="#">شارك معنا</a>
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
    <section class="cover">
        <div class="page-wrapper">
            <h1 class="page-title">إدارة فورم المشاركة</h1>
            <div class="form-card">
                <h4 class="mb-4">
                    <?php echo $editQuestion ? 'تعديل سؤال' : 'إضافة سؤال جديد'; ?>
                </h4>
                <form method="POST">
                    <?php if ($editQuestion): ?>
                    <input type="hidden" name="id" value="<?php echo $editQuestion['id']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label>نص السؤال</label>
                        <textarea name="question_text" class="form-control"
                            required><?php echo htmlspecialchars($editQuestion['question_text'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>نوع السؤال</label>
                        <select name="question_type" class="form-select" required>
                            <?php
                        $types = [
                            'text' => 'نص قصير',
                            'email' => 'بريد إلكتروني',
                            'textarea' => 'نص طويل',
                            'radio' => 'اختيار واحد',
                            'checkbox' => 'مربع اختيار',
                            'file' => 'رفع ملف'
                        ];

                        foreach ($types as $value => $label):
                            $selected = (($editQuestion['question_type'] ?? '') == $value) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $value; ?>" <?php echo $selected; ?>>
                                <?php echo $label; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>الخيارات</label>
                        <textarea name="options" class="form-control"
                            placeholder="خيارات لأسئلة radio أو checkbox"><?php echo htmlspecialchars($editQuestion['options'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>ترتيب السؤال</label>
                        <input type="number" name="question_order" class="form-control"
                            value="<?php echo htmlspecialchars($editQuestion['question_order'] ?? 0); ?>">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_required" id="required"
                            <?php echo !empty($editQuestion['is_required']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="required">
                            سؤال مطلوب
                        </label>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="active"
                            <?php echo (!isset($editQuestion) || !empty($editQuestion['is_active'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="active">
                            إظهار السؤال للمستخدم
                        </label>
                    </div>

                    <?php if ($editQuestion): ?>
                    <button type="submit" name="update_question" class="btn btn-main">
                        حفظ التعديل
                    </button>

                    <a href="adminShareForm.php" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <?php else: ?>
                    <button type="submit" name="add_question" class="btn btn-main">
                        إضافة السؤال
                    </button>
                    <?php endif; ?>

                </form>
            </div>

            <div class="table-card">
                <h4 class="mb-4">أسئلة الفورم الحالية</h4>

                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>السؤال</th>
                                <th>النوع</th>
                                <th>مطلوب؟</th>
                                <th>الحالة</th>
                                <th>الترتيب</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($questions && mysqli_num_rows($questions) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($questions)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>

                                <td style="max-width: 300px;">
                                    <?php echo htmlspecialchars($row['question_text']); ?>
                                </td>

                                <td><?php echo htmlspecialchars($row['question_type']); ?></td>

                                <td>
                                    <?php echo $row['is_required'] ? 'نعم' : 'لا'; ?>
                                </td>

                                <td>
                                    <?php if ($row['is_active']): ?>
                                    <span class="badge badge-active">ظاهر</span>
                                    <?php else: ?>
                                    <span class="badge badge-hidden">مخفي</span>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo $row['question_order']; ?></td>

                                <td>
                                    <a href="adminShareForm.php?edit=<?php echo $row['id']; ?>"
                                        class="btn btn-warning btn-action">
                                        تعديل
                                    </a>

                                    <a href="adminShareForm.php?toggle=<?php echo $row['id']; ?>"
                                        class="btn btn-info btn-action">
                                        <?php echo $row['is_active'] ? 'إخفاء' : 'إظهار'; ?>
                                    </a>

                                    <a href="adminShareForm.php?delete=<?php echo $row['id']; ?>"
                                        class="btn btn-danger btn-action"
                                        onclick="return confirm('هل أنتِ متأكدة من حذف هذا السؤال؟');">
                                        حذف
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7">لا توجد أسئلة مضافة حالياً.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>