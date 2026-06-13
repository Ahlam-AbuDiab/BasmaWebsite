<?php
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
$teamQuery = "SELECT * FROM team ORDER BY id ASC";
$teamResult= mysqli_query($conn, $teamQuery);
$randomImagesQuery = "SELECT image FROM Photos ORDER BY RAND() LIMIT 3";
$randomImages = [];
$randomImagesResult = mysqli_query($conn, $randomImagesQuery);
while($row = mysqli_fetch_assoc($randomImagesResult)){
    $randomImages[] = $row['image'];
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
    <title>فريق العمل</title>
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
                            <a class="nav-link active dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">من نحن</a>
                            <ul class="dropdown-menu">
                                <?php
                                $membersTeam = [
                                    ["id" => 4, "name" => "أحلام أبو دياب"],
                                    ["id" => 5, "name" => "منى حجازي"],
                                    ["id" => 3, "name" => "نورا عاشور"],
                                    ["id" => 2, "name" => "هدى سلامة"]
                                ];
                                $activeMember = $_GET['id'] ?? '';
                                ?>
                                <?php foreach($membersTeam as $member): ?>
                                <li>
                                    <a class="dropdown-item <?php echo ($activeMember == $member['id']) ? 'active' : ''; ?>"
                                        href="userMemberView.php?id=<?php echo $member['id']; ?>">
                                        <?php echo $member['name']; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  text-white" href="#" role="button">شارك معنا</a>
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
    </nav>
    <section class="memory-hero">
        <div class="hero-wrap">
            <div class="hero-textTeam">
                <span class="tag">بصمة | أثرٌ لا يمحوه الركام</span>
                <h1>
                    الهدف من مشروع "بصمة"
                </h1>
                <p>
                    نحن فريق يؤمن بأن لكل إنسان قصة تستحق أن تُروى، ولكل ذكرى بصمة لا يجب أن تُمحى. انطلقت فكرة "بصمة"
                    من إيماننا بأهمية توثيق القصص الإنسانية وحفظها للأجيال القادمة، خاصة تلك التي تعكس معاناة وصمود أهل
                    غزة.
                    نسعى من خلال هذه المنصة إلى إنشاء أرشيف رقمي إنساني يجمع الصور والقصص والشهادات ومقاطع الفيديو في
                    مكان واحد، بهدف إيصال الحقيقة كما عاشها أصحابها، وإبراز التفاصيل الإنسانية التي قد تضيع مع مرور
                    الوقت.
                    نؤمن أن التوثيق ليس مجرد حفظ للمعلومات، بل هو وسيلة للحفاظ على الذاكرة الجماعية، ونقل التجارب
                    الإنسانية إلى العالم بطريقة تحترم أصحابها وتعكس واقعهم بصدق. لذلك جاءت "بصمة" لتكون مساحة تحفظ
                    الأثر، وتخلد الحكايات، وتمنح لكل قصة فرصة لتبقى حية في ذاكرة التاريخ.
                </p>
                <div class="hero-actionsTeam">
                    <a href="dashboardPage.php" class="btn-view">تصفح</a>
                    <a href="#team" class="btn-outline-light-custom">فريق العمل</a>
                </div>
            </div>
            <div class="archive-room">
                <div class="spotlight s1"></div>
                <div class="spotlight s2"></div>
                <div class="spotlight s3"></div>
                <div class="wall-photo one">
                    <img src="../uploads/uploadsPhotos/<?php echo $randomImages[0] ?? '../assets/images/statics/cover.png'; ?>"
                        alt="" class="popup-image">
                </div>
                <div class="wall-photo two">
                    <img src="../uploads/uploadsPhotos/<?php echo $randomImages[1] ?? '../assets/images/statics/cover.png'; ?>"
                        alt="" class="popup-image">
                </div>
                <div class="wall-photo three">
                    <img src="../uploads/uploadsPhotos/<?php echo $randomImages[2] ?? '../assets/images/statics/cover.png'; ?>"
                        alt="" class="popup-image">
                </div>
                <div class="memory-note">
                    <h4>كل صوت له حكاية</h4>
                    <p>وكل حكاية داخل بصمة هي شهادة لا يجب أن تُنسى.</p>
                </div>
                <div class="floor"></div>
            </div>
        </div>
    </section>
    <section class="infor">
        <div class="info-head">
            <h2>ما هي منصة بصمة؟</h2>
            <div class="line"></div>
        </div>
        <div class="identity-grid">
            <div class="identity-main">
                <h3>
                    منصة "بصمة"
                </h3>
                <p>
                    موقع بصمة ليس مجرد منصة إلكترونية لعرض الصور أو الفيديوهات، بل هو مساحة إنسانية وذاكرة رقمية
                    وُجدت لتوثيق قصص الحرب كما عاشها أهل غزة بكل تفاصيلها الحقيقية. جاء هذا المشروع من رحم المعاناة،
                    ليحفظ الحكايات التي قد تضيع وسط الدمار والوقت، وليمنح الناس فرصة لرواية ما عاشوه بأصواتهم
                    ومشاعرهم كما هي، دون تغيير أو تزييف. في بصمة، لا تُعرض الأحداث كأرقام أو أخبار عابرة، بل كقصص
                    إنسانية تحمل الألم والصمود والخوف والأمل، لأن وراء كل صورة حكاية، ووراء كل فيديو حياة كاملة مرت
                    من هنا وتركت أثرًا لا يُمحى.
                    يهدف الموقع إلى توثيق قصص الشهداء، والجرحى، والناجين من تحت الركام، والنازحين، والأسرى، وكل من
                    عاش تجربة غيّرت حياته خلال الحرب على غزة. كما يتيح مساحة لمشاركة التجارب الشخصية والذكريات
                    والمواقف التي عاشها الناس في أصعب الظروف، لتبقى هذه الذاكرة حية لا يطويها النسيان. ويضم الموقع
                    أقسامًا متعددة تشمل القصص المكتوبة، الصور، الفيديوهات، والإحصائيات، ضمن واجهة تحافظ على هوية
                    المكان وتعكس واقع الحرب بصدق وإنسانية.
                    تم تطوير بصمة ليكون أكثر من مجرد مشروع تقني، بل رسالة توثيق وصمود، تؤكد أن ما عاشه الناس لا يجب
                    أن يُنسى مهما مرّ الزمن. فالحرب قد تهدم البيوت والأماكن، لكنها لا تستطيع محو الأثر الذي يتركه
                    الإنسان خلفه. ومن هنا جاءت فكرة الاسم: بصمة… لأن لكل شخص في هذه الحرب بصمته الخاصة، وقصته التي
                    تستحق أن تُروى وتبقى محفورة في الذاكرة
                </p>
            </div>
            <div class="identity-side">
                <div class="mini-card">
                    <a href="userStoriesPage.php">
                        <i class="bi bi-people-fill"></i>
                        <h4>قصص مكتوبة</h4>
                        <p>قصص توثق حكايا أصحابها ومعاناتهم نقلها أصحاب القصة او احبابهم بعد رحيلهم</p>
                    </a>
                </div>
                <div class="mini-card">
                    <a href="userPhotosPage.php">
                        <i class="bi bi-images"></i>
                        <h4>معرض صور</h4>
                        <p>صور مصنفة بطريقة احترافية مع وصف وعرض تفاعلي.</p>
                    </a>
                </div>
                <div class="mini-card">
                    <a href="userVideosPage.php">
                        <i class="bi bi-camera-video"></i>
                        <h4>توثيق مرئي</h4>
                        <p>فيديوهات تساعد على إيصال الحدث بصورة أوضح وأكثر تأثيراً.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="info" id="team">
        <div class="info-head">
            <h2>فريق العمل</h2>
            <div class="line"></div>
        </div>
        <div class="team-grid">
            <?php if($teamResult && mysqli_num_rows($teamResult) > 0): ?>
            <?php while($member = mysqli_fetch_assoc($teamResult)): ?>
            <div class="team-card">
                <a href="userMemberView.php?id=<?php echo $member['id'];?>" class="team-card-link">
                    <div class="team-img">
                        <img src="../uploads/uploadsTeamPhotos/<?php echo htmlspecialchars($member['image']); ?>" alt=""
                            class="team-popup-image">
                    </div>
                    <h4>
                        <?php echo htmlspecialchars($member['name']); ?>
                    </h4>
                    <div class="member-role">
                        <?php echo htmlspecialchars($member['role']); ?>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p style="color:#ccc;text-align:center;">
                لا يوجد أعضاء فريق حالياً
            </p>
            <?php endif; ?>
        </div>
    </section>
    <div class="image-popup" id="imagePopup">
        <span class="close-popup">&times;</span>
        <img id="popupImg" src="" alt="">
    </div>
    <div class="image-popup" id="teamImagePopup">
        <span class="close-popup" id="closeTeamPopup">&times;</span>
        <img id="teamPopupImg" src="" alt="">
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".team-card");
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
    <script src="../assets/js/popup.js"></script>
    <script src="../assets/js/animation.js"></script>
</body>

</html>