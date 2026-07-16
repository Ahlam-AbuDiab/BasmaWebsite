<?php
include '../dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $details = $_POST['details'] ?? '';
    $categoryName = $_POST['categoryName'] ?? '';
    $uploadDir = __DIR__ . "/../uploads/uploadsVideos/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $videoName = time() . "_" . basename($_FILES['video']['name']);
        $targetPath = $uploadDir . $videoName;

        if (move_uploaded_file($_FILES['video']['tmp_name'], $targetPath)) {

            $sql = "INSERT INTO Videos (title, details, categoryName, video)
                    VALUES ('$title', '$details', '$categoryName', '$videoName')";

            if (mysqli_query($conn, $sql)) {
                header("Location: ../admin/adminVideoPage.php?added=1");
                exit;
            } else {
                echo "Database error: " . mysqli_error($conn);
            }

        } else {
            echo "Video upload failed";
        }

    } else {
        echo "No video selected or upload error";
    }
}
?>