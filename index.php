<?php include("PHP/session.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Главная</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/index_inside_style.css" />
    <link rel="stylesheet" href="CSS/index_footer.css" />
    <link rel="stylesheet" href="CSS/hexagons.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!-- HEXAGONS -->

<div id="hexagons" class="content">

    <div class="hex" id="hex-one">
        <a href="aboutme.php" accesskey="H"><img src="Assets/Hexagons/aboutme.png" title="Обо мне"/></a>
    </div>

    <div class="hex" id="hex-two">
        <a href="blog.php" accesskey="H"><img src="Assets/Hexagons/blog.png" title="Блог"/></a>
    </div>

    <div class="hex" id="hex-three">
        <a href="archive.php" accesskey="H"><img src="Assets/Hexagons/archive.png" title="Архив"/></a>
    </div>

    <div class="hex" id="hex-four">
        <a href="browse.php" accesskey="H"><img src="Assets/Hexagons/browse.png" title="Поиск"/></a>
    </div>

    <div class="hex" id="hex-five">
        <a href="contact.php" accesskey="H"><img src="Assets/Hexagons/contact.png" title="Контакт"/></a>
    </div>

</div>

<?php include("footer.php"); ?>

</body>
</html>