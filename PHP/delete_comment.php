<?php
include("only_authorised.php");

if (isset($_GET['id'])) {

    require_once 'dbCon.php';

    $comment_id = $_GET['id'];

    $result = mysqli_query($con, "DELETE FROM post_comment WHERE id = $comment_id");

    if ($result) { //checks if comment is successfully deleted
        http_response_code(200);
    } else {
        http_response_code(500);
        echo "Comment failed to delete: " . mysqli_error($con);
    }
} else {
    http_response_code(403);
    echo "Missing comment id";
}
