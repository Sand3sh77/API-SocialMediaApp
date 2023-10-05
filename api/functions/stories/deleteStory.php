<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $storyId = $_POST['id'];
    $file_path = null; // Initialize $file_path variable

    // Check if 'file_path' is set
    if (isset($_POST['file_path'])) {
        $file = $_POST['file_path'];
        $file_path = '../../images/story/' . substr($file, strrpos($file, '/') + 1);
    }

    $sql = "DELETE FROM stories where id=$storyId";
    $result = mysqli_query($con, $sql);
    if ($result) {
        // Check if $file_path is set before trying to delete the file
        if ($file_path !== null && file_exists($file_path)) {
            unlink($file_path);
        }
        echo json_encode([
            "status" => 200,
            "message" => "Story deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occurred"
        ]);
    }
}
?>