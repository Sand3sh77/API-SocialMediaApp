<?php
include "../../connection/config.php";
header('Access-Control-Allow-Origin: *');

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $id = $_POST['id'];
    $search = $_POST['search'];

    $sql = "SELECT * FROM users where name LIKE '$search%' OR email LIKE '$search%'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if ($result) {
        if ($num > 0) {
            $users = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
            echo json_encode([
                "status" => 200,
                "message" => "Results obtained succesfully",
                "data" => $users
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "No result found."
            ]);
        }
    } else {
        echo json_encode([
            "status" => 501,
            "message" => "Failed to get data"
        ]);
    }
}
?>