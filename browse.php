<?php include("PHP/session.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Tiny Darya || Поиск</title>
    <link rel="stylesheet" href="CSS/foundation.css" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="CSS/browse_style.css" />
    <link href='http://fonts.googleapis.com/css?family=Poiret+One&subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="Assets/favicon.ico"/>
    <script src="JS/functions.js"></script>
</head>
<body>

<?php include("header.php"); ?>

<!-- MAIN SECTION -->

<div id="browse" class="small-12 columns">

    <!-- Text -->
        <div id="container">
            <h1>Не смогли найти нужный пост?</h1>
            <p id="p-text">Просто введите несколько слов чтобы найти посты ^^</p>
        </div>

        <?php if (isset($_GET['error'])) { ?>
            <div class="error-message">Не удалось найти посты из-за ошибки :(</div>
        <?php } else if (isset($_GET['noresult'])) { ?>
            <div class="error-message">К сожалению, таких постов не найдено :(</div>
        <?php }?>

    <!-- Input -->
        <form id="search" action="blog.php" method="get">
            <input id="input" type="search" name="search" value=" " />
            <input id="button" type="submit" value="ПОИСК" />
        </form>

</div>

<?php include("footer.php"); ?>

</body>
</body>
</html>