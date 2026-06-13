<?php
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
$success = "";
$error = "";
$questions = [];
$q = mysqli_query($conn,"
    SELECT * 
    FROM share_form_question
    WHERE is_active = 1
    ORDER BY question_order
");
while($row = mysqli_fetch_assoc($q)){
    $questions[] = $row;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $answers = [];
    foreach($questions as $question){
        $answers[$question['question_order']] =
            trim($_POST["question_{$question['id']}"] ?? '');
    }
    $nameType = (strpos($answers[1] ?? '', 'مجهول') !== false)
        ? 'anonymous'
        : 'real';
    $email     = $answers[2] ?? '';
    $storyType = $answers[3] ?? '';
    $title     = $answers[4] ?? '';
    $storyText = $answers[5] ?? '';
    $fileName = null;
    foreach($questions as $question){
        if($question['question_type'] !== 'file'){
            continue;
        }
        $file = $_FILES["question_{$question['id']}"] ?? null;
        if(!$file || empty($file['name'])){
            continue;
        }
        $allowed = ['jpg','jpeg','png','gif','webp','mp4','mov','avi','mkv'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)){
            $error = "نوع الملف غير مسموح";
            break;
        }
        $uploadDir = "../uploads/submissions/";
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . "." . $ext;
        move_uploaded_file(
            $file['tmp_name'],
            $uploadDir . $fileName
        );
    }
    if(
        !$error &&
        $email &&
        $storyType &&
        $title &&
        $storyText &&
        isset($_POST['agreement'])
    ){
        $stmt = mysqli_prepare($conn,"
            INSERT INTO submissions
            (name_type,email,story_type,title,story_text,image,approval,status)
            VALUES (?,?,?,?,?,?,0,'pending')
        ");
        mysqli_stmt_bind_param(
            $stmt,
            "ssssss",
            $nameType,
            $email,
            $storyType,
            $title,
            $storyText,
            $fileName
        );
        if(mysqli_stmt_execute($stmt)){
            $success = "تم إرسال مشاركتك بنجاح";
        }else{
            $error = "فشل حفظ المشاركة";
        }
    }elseif(!$error){
        $error = "يرجى تعبئة جميع الحقول المطلوبة والموافقة على الشروط";
    }
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
    <title>شارك معنا</title>
    <style>
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
                            <a class="nav-link active text-white" href="#" role="button">شارك معنا</a>
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
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
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
    <section class="share-page">
        <div class="share-container">
            <div class="share-info">
                <span class="share-badge">شارك معنا</span>
                <h1>بصمة...... أثرٌ لا يمحوه الركام</h1>
                <p>
                    في قلب كل حدث هناك قصة .... وفي كل قصة هناك انسان
                    من هنا انطلقنا نحن مجموعة طالبات من كلية تكنولوجيا المعلومات في الجامعة الاسلامية باطلاق مشروع
                    تخرجنا على هيئة منصة ويب (بصمة) التي ستكون أرشيف رقمي يعكس التجربة الانسانية وتوثيق القصص
                    المرتبطة
                    بالحرب على غزة ليس فقط كأحداث تُروى بل كذكريات تُحفظ وشهادات تبقى شاهدة على ما حدث .
                    هذا النموذج هو مساحة آمنة لك لتشارك تجربتك أو موقفاً عايشته أو قصة تحمل أثر لا يُنسى سواء كانت
                    لحظة
                    ألم، فقدان، صمود أو انسانية.
                    إن مشاركتك تساهم في حفظ الذاكرة الجماعية ونقل الحقيقة عبر الأجيال القادمة
                </p>

                <div class="info-points">

                    <div class="info-point">
                        <i class="bi bi-lock-fill"></i>
                        <span> جميع المشاركات سيتم التعامل معها بخصوصية واحترام</span>
                    </div>

                    <div class="info-point">
                        <i class="bi bi-camera"></i>
                        <span> يمكنك إضافة صور توثق القصص والمعانة في الحرب. </span>
                    </div>

                    <div class="info-point">
                        <i class="bi bi-pencil-square"></i>
                        <span> قد يتم إجراء تعديلات لغوية بسيطة دون تغيير المعنى.</span>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-title">
                    <span>نموذج المشاركة</span>
                    <h2>شارك قصتك</h2>
                </div>
                <?php if($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>
                <?php if($error): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <?php foreach($questions as $question): ?>
                    <?php
                    $id = $question['id'];
                    $text = $question['question_text'];
                    $type = $question['question_type'];
                    $options = $question['options'];
                    $required = $question['is_required'] == 1 ? 'required' : '';
                    $name = "question_" . $id;
                    $hasOptions = trim((string)$options) !== "";
                    ?>
                    <div class="form-group">
                        <label class="form-label">
                            <?php echo htmlspecialchars($text); ?>
                            <?php if($required): ?>
                            <span class="required-star">*</span>
                            <?php endif; ?>
                        </label>
                        <?php if($type === 'textarea'): ?>
                        <textarea class="form-control" name="<?php echo $name; ?>" placeholder="اكتب هنا..."
                            <?php echo $required; ?>></textarea>
                        <?php elseif($type === 'radio' || $hasOptions): ?>
                        <div class="radio-list">
                            <?php
                            $opts = preg_split('/\r\n|\r|\n/', $options);
                            foreach($opts as $opt):
                            $opt = trim($opt);
                            if($opt === '') continue;
                            ?>
                            <label class="radio-option">
                                <input type="radio" name="<?php echo $name; ?>"
                                    value="<?php echo htmlspecialchars($opt); ?>" <?php echo $required; ?>>
                                <span><?php echo htmlspecialchars($opt); ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        <?php elseif($type === 'file'): ?>
                        <div class="file-box">
                            <input class="form-control" type="file" name="<?php echo $name; ?>" accept="image/*,video/*"
                                <?php echo $required; ?>>

                            <div class="file-hint">
                                يمكنك رفع صورة تدعم القصة.
                            </div>
                        </div>
                        <?php else: ?>
                        <input class="form-control"
                            type="<?php echo (strpos($text, 'البريد') !== false) ? 'email' : 'text'; ?>"
                            name="<?php echo $name; ?>" placeholder="اكتب الإجابة هنا" <?php echo $required; ?>>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                    <div class="agreement-box">
                        <label>
                            <input type="checkbox" name="agreement" required>
                            <span>أوافق على استخدام القصة والوسائط في موقع بصمة</span>
                        </label>
                    </div>
                    <button type="submit" class="submit-btn">
                        إرسال المشاركة
                    </button>
                </form>
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