<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../dbConnection.php';
mysqli_set_charset($conn, "utf8mb4");
if (isset($_POST['save_video'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    if (!isset($_FILES['video']) || $_FILES['video']['error'] !== 0) {
        die("Video upload error");
    }
    $upload_dir = "../uploads/uploadsVideos/";
    $posterDir = "../uploads/uploadsVideoPosters/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (!is_dir($posterDir)) {
        mkdir($posterDir, 0777, true);
    }
    $videoName = basename($_FILES['video']['name']);
    $tmpName = $_FILES['video']['tmp_name'];
    $extension = pathinfo($videoName, PATHINFO_EXTENSION);
    $safeName = time() . "_" . uniqid() . "." . $extension;
    $videoPath = $uploadDir . $safeName;
    if (!move_uploaded_file($tmpName, $videoPath)) {
        die("Video upload failed");
    }
    $posterName = pathinfo($safeName, PATHINFO_FILENAME) . ".jpg";
    $posterPath = $posterDir . $posterName;
    $ffmpeg = "/opt/homebrew/bin/ffmpeg";
    exec(
        $ffmpeg . " -y -ss 00:00:03 -i " . escapeshellarg($videoPath) . " -frames:v 1 -update 1 " . escapeshellarg($posterPath) . " 2>&1",
        $output,
        $returnCode
    );
    if ($returnCode !== 0) {
        echo "<h3>FFmpeg Error:</h3>";
        echo "<pre>";
        print_r($output);
        echo "</pre>";
        exit;
    }
    $query = "INSERT INTO Videos (title, details, categoryName, video, poster)
              VALUES ('$title', '$details', '$categoryName', '$safeName', '$posterName')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/adminVideoPage.php?success=1");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../admin/addVideo.php");
    exit();
}
?>