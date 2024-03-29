<?php
include "../../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];
    $limit = $_GET["limit"];

    $sql = "SELECT DISTINCT n.id, u.name, u.profilePic,n.notification,n.createdAt,n.userId,n.postId,u.method
    FROM users u
    INNER JOIN notifications n ON u.id = n.userId
    INNER JOIN relationships r ON u.id=r.followedUserId
    WHERE r.followerUserId=$id AND n.createdAt>=r.followedAt
    ORDER BY n.id DESC
    LIMIT $limit";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode([
            "status" => 200,
            "message" => "Notifications obtained succesfully",
            "data" => $data
        ]);
    } else {
        echo json_encode([
            "status" => 500,
            "message" => "Some error occured"
        ]);
    }

}

?>