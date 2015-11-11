<?php
include("only_authorised.php");

if (isset($_GET['id'])) {

    require_once 'dbCon.php';

    $post_id = $_GET['id'];

    $result = mysqli_query($con, "DELETE FROM post WHERE id = $post_id");

    if ($result) { //checks if post is successfully deleted
        http_response_code(200);
    } else {
        http_response_code(500);
        echo "Post failed to delete: " . mysqli_error($con);
    }
} else {
    http_response_code(403);
    echo "Missing post id";
}
