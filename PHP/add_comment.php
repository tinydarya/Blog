<?php

if ($_POST) {
    if (isset($_POST['post_id'])) {
        if (isset($_POST['comment'])) {
            if (isset($_POST['email'])) {
                require_once 'dbCon.php';

                $post_id = mysqli_real_escape_string($con, $_POST['post_id']);
                $text = mysqli_real_escape_string($con, $_POST['comment']);

                $name = isset($_POST['name']) ? "'".mysqli_real_escape_string($con, $_POST['name'])."'" : "NULL";
                $email = isset($_POST['email']) ? "'".mysqli_real_escape_string($con, $_POST['email'])."'" : "NULL";

                //create a new row in post_comment table in db
                $sql = "INSERT INTO post_comment (email, name, text, post_id) VALUES ($email,$name, '$text', $post_id)";
                $result = mysqli_query($con, $sql);

                if (!$result) { //checks if comment is successfully created
                    echo "Failed to add comment: " . mysqli_error($con);
                } else {
                    header("location: #comments");
                }
            } else {
                echo "Missing email";
            }
        } else {
            echo "Missing text";
        }
    } else {
        echo "Missing post id";
    }
}
