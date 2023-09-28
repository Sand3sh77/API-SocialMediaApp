<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postId = $_POST['id'];
    $file_path = null; // Initialize $file_path variable

    // Check if 'file_path' is set
    if (isset($_POST['file_path']) && file_exists($_POST['file_path'])) {
        $file = $_POST['file_path'];
        $file_path = '../images/post/' . substr($file, strrpos($file, '/') + 1);
    }

    $sql = "DELETE FROM posts where id=$postId";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // Check if $file_path is set before trying to delete the file
        if ($file_path !== null && file_exists($file_path)) {
            unlink($file_path);
        }
        echo json_encode([
            "status" => 200,
            "message" => "Post removed successfully"
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occurred"
        ]);
    }
}
?>