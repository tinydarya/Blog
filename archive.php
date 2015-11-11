<?php include("PHP/session.php");
include("PHP/functions.php");?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Архив</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/archive_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!-- MAIN SECTION -->
<div id="archive" class="small-12 columns">


    <?php
    require_once 'PHP/dbCon.php';

    function substrhtml($str,$start,$len){

        $str_clean = substr(strip_tags($str),$start,$len);
        $pos = strrpos($str_clean, " ");
        if($pos === false) {
            $str_clean = substr(strip_tags($str),$start,$len);
        }else
            $str_clean = substr(strip_tags($str),$start,$pos);

        if(preg_match_all('/\<[^>]+>/is',$str,$matches,PREG_OFFSET_CAPTURE)){

            for($i=0;$i<count($matches[0]);$i++){

                if($matches[0][$i][1] < $len){

                    $str_clean = substr($str_clean,0,$matches[0][$i][1]) . $matches[0][$i][0] . substr($str_clean,$matches[0][$i][1]);

                }else if(preg_match('/\<[^>]+>$/is',$matches[0][$i][0])){

                    $str_clean = substr($str_clean,0,$matches[0][$i][1]) . $matches[0][$i][0] . substr($str_clean,$matches[0][$i][1]);

                    break;

                }

            }

            return $str_clean;

        }else{
            $string = substr($str,$start,$len);
            $pos = strrpos($string, " ");
            if($pos === false) {
                return substr($str,$start,$len);
            }
            return substr($str,$start,$pos);

        }

    }

    /**
     * string csubstr ( string string, int start [, int length] )
     *
     * @author FanFataL
     * @param string string
     * @param int start
     * @param [int length]
     * @return string
     */
    function csubstr($string, $start, $length=false) {
        $pattern = '/(\[\w+[^\]]*?\]|\[\/\w+\]|<\w+[^>]*?>|<\/\w+>)/i';
        $clean = preg_replace($pattern, chr(1), $string);
        if(!$length)
            $str = substr($clean, $start);
        else {
            $str = substr($clean, $start, $length);
            $str = substr($clean, $start, $length + substr_count($str, chr(1)));
        }
        $pattern = str_replace(chr(1),'(.*?)',preg_quote($str));
        if(preg_match('/'.$pattern.'/is', $string, $matched))
            return $matched[0];
        return $string;
    }

    //if parameter tag_id is set in URL
    if (isset($_GET['tag_id'])) {
        $tag_id = $_GET['tag_id'];
        $posts = mysqli_query($con, "SELECT p.id, p.title, p.text, p.date, p.user_id FROM post p LEFT JOIN post_tag t ON t.post_id = p.id WHERE t.tag_id = $tag_id ORDER BY p.date DESC");
    } else {
        $posts = mysqli_query($con, "SELECT p.*, COUNT(c.id) AS comments FROM post p LEFT JOIN post_comment c ON c.post_id = p.id GROUP BY p.id ORDER BY p.date DESC");
    }

    if (!$posts) {
        echo "Failed to fetch posts";
    } else {
    while ($post = mysqli_fetch_assoc($posts)) { //starts loop for each found post

        $post_id = $post['id'];
        $date = getdate(strtotime($post['date'])); ?>

        <div class="post">
            <div class="post-contents" onclick="openPost(<?= $post_id ?>)">
                <?php
                $result = mysqli_query($con, "SELECT i.id, i.path FROM image i LEFT JOIN post_image p ON i.id = p.image_id WHERE p.post_id = $post_id AND p.`order` = 0");
                if (!$result) {
                    echo "Failed to fetch image: ".mysqli_error($con);
                } else if (mysqli_num_rows($result) > 0) {
                    $image = mysqli_fetch_assoc($result);

                    $text = $post['text'];
                    if (strlen($text) > 140) {
                        $text = trim(substrhtml(csubstr($text, 0, 140), 0, 140));
                        if (strlen($post['text']) > strlen($text)) {
                            $text .= "...";
                        }
                    }
                    ?>

                    <!-- Main picture -->
                    <img class="main-pic" src="<?= $image['path'] ?>"/>
                <?php } ?>

                <!-- Post heading -->
                <a href="post.php?id=<?= $post_id ?>"><h1><?= $post['title'] ?></h1></a>
                <!-- Text -->
                <p class="main-text"><?= $text ?></p>

                <!-- Hashtags -->
                <div id="hashtags">
                    <?php
                    $result = mysqli_query($con, "SELECT t.id, t.name FROM tag t LEFT JOIN post_tag p ON t.id = p.tag_id WHERE p.post_id = $post_id");
                    if (!$result) {
                        echo "Failed to fetch tags";
                    } else {
                        while ($tag = mysqli_fetch_assoc($result)) {?>
                            <a href="blog.php?tag_id=<?= $tag['id'] ?>"><p class="tag"><?= $tag['name'] ?></p></a>
                        <?php }
                    }
                    ?>
                </div>

                <hr>

                <!-- Date -->
                <p class="date-com"><?= $date['mday']." ".convertMonth($date['mon'])." ".$date['year']; ?></p>

                <!-- Comments -->
                <a href="post.php?id=<?= $post_id ?>#comments" style="color: black;">
                    <p id="com" class="date-com">Комментариев: <?= $post['comments'] ?></p>
                </a>
            </div>
        </div>
    <?php }
    } ?>

</div>

<script>
    function openPost(id) {
        window.location = "post.php?id=" + id;
    }
</script>

<?php include("footer.php"); ?>

</body>
</html>