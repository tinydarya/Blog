<?php include("PHP/session.php");
include("PHP/functions.php");

function fetchData($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Обо мне</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/aboutme_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!-- MAIN SECTION -->

<!--Main information-->
<div id="main-section" class="small-12 columns">


    <?php
    require_once 'PHP/dbCon.php';

    $user = mysqli_query($con, "SELECT * FROM user WHERE id = 1");

    if (!$user) {
        echo "Failed to fetch information";
    } else {
     $user = mysqli_fetch_assoc($user);

        $date = getdate(strtotime($user['dob']));
        ?>

    <!-- Text -->
    <div  class="small-8 columns">
        <div class="row">
            <div id="info">
                <div class="small-9 columns">
                    <p class="main-info"><?= $user['name']; ?></p>
                    <p class="main-info"><?= $user['location']; ?></p>
                    <p class="main-info"><?= $date['mday']." ".convertMonth($date['mon']); ?></p>
                </div>

                <?php if ($authorized) { ?>

                <!-- Button -->
                <div class="small-3 columns" id="button">
                    <form action="edit_aboutme.php" method="get" title="Edit">
                        <button class="edit-btn"/>
                    </form>
                </div>

                <?php } ?>

            </div>
        </div>

        <!--About-->
        <div id="main-text">
            <div id="about">
                <p id="about-info"><?php echo $user['bio']; ?></p>
            </div>
        </div>

    </div>
    <?php }
    ?>

    <!-- Picture -->
    <div class="small-4 columns">

        <!-- Picture -->
        <form action="upload.php" method="post" enctype="multipart/form-data">

            <?php $image_id = $user['image_id'];
            $result = mysqli_query($con, "SELECT * FROM image WHERE id = $image_id");
            if (!$result) {
                echo "Failed to fetch image";
            } else {
                $result = mysqli_fetch_assoc($result);?>
                <img id="image" src="<?php echo $result['path']; ?>" />
            <?php }?>
    </div>

</div>

<!-- Instagram -->
<div class="small-12 columns">
    <div id="instagram">
        <a id="insta" title="Instagram link" href="http://www.instagram.com/tinydarya" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;" accesskey="I"><p id="insta-head">INSTAGRAM</p></a>
        <div id="insta-imgs">
            <?php
            $result = fetchData("https://api.instagram.com/v1/users/241201975/media/recent/?access_token=241201975.ab103e5.f2fad86bbcec468a9e792bde34ea5554&count=6");
            $result = json_decode($result);
            foreach ($result->data as $post) { ?>
                <a target="_blank" href="<?= $post->link ?>">
                    <img class="insta-img" src="<?= $post->images->thumbnail->url ?>" alt="Instagram image"/>
                </a>
            <?php }
            ?>
        </div>
    </div>

    <!-- YouTube -->
    <div id="youtube">
        <a id="youtube-link" title="YouTube Channel link" href="http://youtube.com/tinydarya" target="_blank" accesskey="Y"><p id="youtube-head">YOUTUBE</p></a>
        <div id="youtube-imgs">
            <?php
            $result = fetchData("https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCSMMGR9Jsc2h2pvu5Aeu8eQ&maxResults=3&order=date&type=video&fields=items(id%2Csnippet(thumbnails(medium)))&key=AIzaSyBbIenFikfle6SIAjIGMQFd6RPxo_3UWec");
            $result = json_decode($result);
            foreach ($result->items as $video) { ?>
                <a target="_blank" href="https://youtube.com/watch?v=<?= $video->id->videoId ?>">
                    <img class="youtube-img" src="<?= $video->snippet->thumbnails->medium->url ?>" alt="YouTube Video"/>
                </a>
            <?php }
            ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>


</body>
</html>