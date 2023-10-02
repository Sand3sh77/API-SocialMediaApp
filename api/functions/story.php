<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];

    $sql = "SELECT stories.id, stories.img, stories.createdAt, users.name FROM stories INNER JOIN users ON stories.userId = users.id WHERE stories.id='$id' ORDER BY stories.id DESC";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $story = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $story[] = $row;
        }
        echo json_encode([
            "status" => 200,
            "message" => "Stories obtained succesfully",
            "data" => $story
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }

}


?>