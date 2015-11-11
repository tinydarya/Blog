<?php

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

require_once("dbCon.php");


$result = mysqli_query($con, "SELECT i.id, i.path FROM image i LEFT JOIN post_image p ON i.id = p.image_id WHERE p.post_id = $post_id ORDER BY p.`order`");


if (!$result) {
    echo "Failed to fetch posts";
} else {
    while ($image = mysqli_fetch_assoc($result)) { //starts loop for each found post
    }
    }
}
        ?>

