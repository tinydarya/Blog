<?php
require_once 'dbCon.php';
if (isset($_GET['search'])) {
    $full_query_match = strtoupper("%".mysqli_real_escape_string($con, trim($_GET['search']))."%");

    $keyword_tokens = explode(' ', trim($_GET['search']));
    $keyword_tokens = array_map(
        function ($keyword) use ($con) {
            return mysqli_real_escape_string($con, trim($keyword));
        },
        $keyword_tokens
    );
    $individual_keywords_match = strtoupper("%".implode("%' OR p.text LIKE '%", $keyword_tokens)."%");

    $sql = "SELECT p.*, COUNT(c.id) AS comments FROM post p LEFT JOIN post_comment c ON c.post_id = p.id WHERE UPPER(p.text) LIKE '$full_query_match' OR UPPER(p.text) LIKE '$individual_keywords_match' OR UPPER(p.title) LIKE '$full_query_match' OR UPPER(p.title) LIKE '$individual_keywords_match' GROUP BY p.id";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        header('location: browse.php?error');
    } else if (mysqli_num_rows($result) == 0) {
        header('location: browse.php?noresult');
    } else {
        $posts = $result;
    }
}
?>

