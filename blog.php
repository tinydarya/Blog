<?php include("PHP/session.php");
include("PHP/search.php");
include("PHP/functions.php");?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Блог</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/blog_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!-- MAIN SECTION -->
<div id="main-section" class="small-12 columns">

    <div class="small-12 columns">

        <?php
        require_once("PHP/dbCon.php");
        //if parameter tag_id is set in URL
        if (isset($_GET['tag_id'])) {
            $tag_id = $_GET['tag_id'];
            $posts = mysqli_query($con, "SELECT p.*, COUNT(c.id) AS comments FROM post p LEFT JOIN post_tag t ON t.post_id = p.id LEFT JOIN post_comment c ON c.post_id = p.id WHERE t.tag_id = $tag_id GROUP BY p.id ORDER BY p.date DESC");
        } else if (!isset($posts)) {
            $posts = mysqli_query($con, "SELECT p.*, COUNT(c.id) AS comments FROM post p LEFT JOIN post_comment c ON c.post_id = p.id GROUP BY p.id ORDER BY p.date DESC LIMIT 3");
        }

        if (!$posts) {
            echo "Failed to fetch posts";
        } else {
            while ($post = mysqli_fetch_assoc($posts)) { //starts loop for each found post
                $post_id = $post['id'];
                $date = getdate(strtotime($post['date'])); ?>

                <!-- POST ONE-->
                <div class="row post">

                    <!-- Date and number of comments-->
                    <div class="date-comments small-2 columns">
                        <div class="date">
                            <p class="text" class="left"><?= convertWeekDay($date['wday']); ?></p>
                            <p class="number" class="left"><?= $date['mday']; ?></p>
                            <p class="text" class="left"><?= convertMonth($date['mon'])." ".$date['year']; ?></p>
                        </div>

                        <hr>

                        <a href="post.php?id=<?php echo $post['id']; ?>#comments" style="color: black;">
                            <div class="comments">
                                <p class="text" class="left">Комментариев:</p>
                                <p class="number" class="left"><?php echo $post['comments']; ?></p>
                            </div>
                        </a>

                        <hr>
                    </div>

                    <!-- Post -->
                    <div class="post-main small-10 columns">
                        <div class="post-body">

                            <!-- Heading -->
                            <div class="row post-title">
                                <div class="small-10 columns">
                                    <a href="post.php?id=<?php echo $post['id']; ?>"><h1><?php echo $post['title']; ?></h1></a>
                                </div>

                                <?php if ($authorized) { ?>

                                    <a class="button edit-btn" href="edit_post.php?id=<?php echo $post_id; ?>" title="Edit" ></a>

                                <?php } ?>

                            </div>

                            <?php
                                $result = mysqli_query($con, "SELECT i.id, i.path FROM image i LEFT JOIN post_image p ON i.id = p.image_id WHERE p.post_id = $post_id ORDER BY p.`order`");
                                if (!$result) {
                                    echo "Failed to fetch images: ".mysqli_error($con);
                                } else if (mysqli_num_rows($result) > 0) {
                                    $i = 0;
                                    while ($image = mysqli_fetch_assoc($result)) {
                                        if ($i == 0) {?>
                                            <!-- Main picture -->
                                            <img class="main-pic" src="<?php echo $image['path']; ?>"/>
                                            <!-- Text -->
                                            <p class="main-text"><?php echo $post['text']; ?></p>
                                            <!-- Other pictures -->
                                        <?php } else {?>
                                            <img class="extra-img" src="<?php echo $image['path']; ?>"/>
                                    <?php }
                                        $i++;
                                    }
                                } else {?>
                                    <!-- Text -->
                                    <p class="main-text"><?php echo $post['text']; ?></p>
                                <?php }?>

                            <!-- Hashtags -->
                            <div class="hashtags">
                                <?php
                                    $result = mysqli_query($con, "SELECT t.id, t.name FROM tag t LEFT JOIN post_tag p ON t.id = p.tag_id WHERE p.post_id = $post_id");
                                    if (!$result) {
                                        echo "Failed to fetch tags";
                                    } else {
                                        while ($tag = mysqli_fetch_assoc($result)) {?>
                                            <a href="blog.php?tag_id=<?php echo $tag['id']; ?>"><p class="tag"><?php echo $tag['name']; ?></p></a>
                                        <?php }
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php }
        }
        ?>

    </div>
</div>

<div id="more">
    <p>Чтобы увидеть больше постов, пожалуйста, зайдите в мой <a id="archive-link" href="archive.php">Архив</a> ^^</p>
</div>

<?php include("footer.php"); ?>


</body>
</html>