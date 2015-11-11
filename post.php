<?php include("PHP/session.php");
include("PHP/add_comment.php");
include("PHP/functions.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <title>Tiny Darya || Blog</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/blog_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php
    include("header.php");

    //if parameter id is set in URL
    if (isset($_GET['id'])) {

    //connect with database
    require_once 'PHP/dbCon.php';

    //get post id
    $post_id = $_GET['id'];

    //finds a post with this id
    $result = mysqli_query($con, "SELECT * FROM post WHERE id = $post_id");

    //if not found (result is false)
    if (!$result) {
        echo "Failed to fetch post";

        //once checked the database and post was not found (result is empty)
    } else if (mysqli_num_rows($result) == 0) {?>
        <script>
            alert("Post doesn't exist");
            window.location.href = "blog.php";
        </script>

    <?php } else { //post was found
    //take the data from the database and paste it into html fields

    //extracts post as an associative array (column values can be accessed by column names)
    $post = mysqli_fetch_assoc($result);

    //parse post date to an associative array (various date parts can be accessed by their names)
    $date = getdate(strtotime($post['date']));

    $comments = mysqli_query($con, "SELECT * FROM post_comment WHERE post_id = $post_id ORDER BY date DESC");
    if (!$comments) {

    } else {?>

        <!-- MAIN SECTION -->
        <div id="main-section" class="small-12 columns">
            <div>
                <div class="row post">

                    <!-- Date and number of comments-->
                    <div class="date-comments small-2 columns">
                        <div class="date">
                            <p class="text" class="left"><?= convertWeekDay($date['wday']); ?></p>
                            <p class="number" class="left"><?= $date['mday']; ?></p>
                            <p class="text" class="left"><?= convertMonth($date['mon'])." ".$date['year']; ?></p>
                        </div>

                        <hr>

                        <a href="#comments" style="color: black;"><div class="comments">
                            <p class="text">Комментариев:</p>
                            <p id="comments-number" class="number"><?php echo mysqli_num_rows($comments); ?></p>
                        </div></a>

                        <hr>
                    </div>

                    <!-- Post -->
                    <div class="post-main small-10 columns">
                        <div class="post-body">

                            <!-- Heading -->
                            <div class="row post-title">
                                <div class="small-10 columns">
                                    <a href="post.php?id=<?php echo $post['id']; /* create a link to this specific post */?>"><h1><?php echo $post['title']; ?></h1></a>
                                </div>

                                <?php if ($authorized) { ?>
                                <!-- If the user is authorized show the button -->
                                    <a class="button edit-btn" href="edit_post.php?id=<?php echo $post_id; ?>" title="Edit" ></a>

                                <?php } ?>

                            </div>

                            <?php
                            //find all post images in order they were added to the post
                            $result = mysqli_query($con, "SELECT i.id, i.path FROM image i LEFT JOIN post_image p ON i.id = p.image_id WHERE p.post_id = $post_id ORDER BY p.`order`");
                            if (!$result) {
                                echo "Failed to fetch images: ".mysqli_error($con);
                            } else if (mysqli_num_rows($result) > 0) {

                                $i = 0; //counter
                                while ($image = mysqli_fetch_assoc($result)) { //for each post image
                                    //if it is the first image
                                    if ($i == 0) {?>
                                        <!-- Main picture -->
                                        <img class="main-pic" src="<?php echo $image['path']; ?>"/>
                                        <!-- Text -->
                                        <p class="main-text"><?php echo $post['text']; ?></p>
                                        <!-- Other pictures -->
                                    <?php } else { /* if second and other pictures */?>
                                        <img class="extra-img" src="<?php echo $image['path']; ?>"/>
                                    <?php }
                                    $i++; //increase counter by one
                                }
                            } else { /* if post has no images */?>
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
                                    while ($tag = mysqli_fetch_assoc($result)) {/* for each tag */?>
                                        <a href="blog.php?tag_id=<?php echo $tag['id']; /* creates a URL for all posts with this tag */?>"><p class="tag"><?php echo $tag['name']; ?></p></a>
                                    <?php }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <!-- Existing comments-->

            <div id="comments">
                <h1>Комментарии</h1>
                <?php
                while ($comment = mysqli_fetch_assoc($comments)) {
                    $date = getdate(strtotime($comment['date']));
                    $date_string = $date['mday']." ".convertMonth($date['mon'])." ".$date['year'].", ".date("h:i A", strtotime($comment['date'])); ?>
                    <div id="comment<?php echo $comment['id'];?>" class="comment">
                        <?php if ($authorized) { ?>
                            <button class="comment-delete-btn" onclick="deleteComment(<?php echo $comment['id']; ?>)">Delete</button>
                        <?php } ?>
                        <p id="com-name" class="comment-name"><?php echo $comment['name'] != null ? $comment['name'] : "Аноним"; ?></p>
                        <p id="com-date" class="comment-date"><?php echo $date_string; ?></p>
                        <?php if ($authorized && $comment['email'] != null) { ?>
                            <p id="com-email" class="comment-email"><?php echo $comment['email']; ?></p>
                        <?php } ?>
                        <p id="com-text" class="comment-text"><?php echo $comment['text']; ?></p>
                    </div>
                <?php }
                ?>
            </div>
        <?php } ?>
    </div>

    <!-- Comment form-->
    <div id="com-form" class="small-12 columns">
        <form id="form" action="" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
            <!-- Heading -->
            <h1>Оставить комментарий</h1>

            <!-- Paragraph -->
            <p>Ваш емайл не будет показан.</p>

            <!-- Name -->
            <div>
                <label>Имя:</label>
                <input class="input" name="name" type="text"/>
            </div>

            <!-- Email -->
            <div>
                <label>Емаил*:</label>
                <input type="email" class="input" name="email" required />
            </div>

            <!-- Comment -->
            <div>
                <label>Комментарий*:</label>
                <textarea class="input" name="comment" required cols="45" rows="8"></textarea>
            </div>

            <!-- Button -->
            <div>
                <input id="button" type="submit" value="Отправить" />
            </div>
        </form>
            <script>
                function deleteComment(id) {
                    jQuery.ajax('PHP/delete_comment.php', {
                        data: {id: id},
                        success: function (data, status, jqXHR) {
                            var comment = document.getElementById('comment'+id);
                            comment.parentNode.removeChild(comment);

                            var commentsNumberElement = document.getElementById('comments-number');
                            var commentsNumber = commentsNumberElement.innerHTML;
                            commentsNumberElement.innerHTML = commentsNumber - 1;
                        },
                        error: function (jqXHR, status, error) {
                            alert("Failed to delete comment: " + error);
                        }
                    })
                }
            </script>
    </div>
<?php } ?>


<?php include("footer.php"); ?>


</body>
</html>