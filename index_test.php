<?php

    require_once('./detector.php');
    require_once('./common.php');

    $mysqli = DBConnect();

    $currPage = isset($_GET['currPage']) && !empty($_GET['currPage']) ? $_GET['currPage'] : 0;
    $currBlock = isset($_GET['currBlock']) && !empty($_GET['currBlock']) ? $_GET['currBlock'] : 0;
    $cntPerPage = 1;   // 한 페이지에 보여질 item 수
    $numberOfRows = getNumberOfRows();
    $articles = getArticles();
    $paging = get_paging($currPage, $numberOfRows, $cntPerPage, $currBlock, 'index.php');

    $rightSideArticles = getRightSideArticles();
    $numOfRightSideArticles = getNumOfRightSideArticles();

    function getNumberOfRows(){
        global $mysqli;
        $sql = "SELECT COUNT(id) AS numberOfRows FROM article";
        $rows = get_rows($mysqli, $sql);
        return $rows[0]['numberOfRows'];
    }

    function getArticles(){
        global $mysqli, $currPage, $cntPerPage;
        $curr = $currPage*$cntPerPage;
        $sql = "SELECT * FROM article ORDER BY created_time DESC LIMIT $curr, $cntPerPage";
        $rows = get_rows($mysqli, $sql);
        return $rows;
    }

    function getRightSideArticles(){
        global $mysqli;
        $sql = "SELECT * FROM article ORDER BY created_time DESC LIMIT 20";
        $rows = get_rows($mysqli, $sql);
        return $rows;
    }

    function getNumOfRightSideArticles(){
        global $mysqli;
        $sql = "SELECT COUNT(id) FROM article LIMIT 20";
        $rows = get_rows($mysqli, $sql);
        return $rows;
        // max == 20
    }

    $mysqli->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=1020">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="./resources/css/default.css" rel="stylesheet" type="text/css">
<link href="./resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./resources/js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="./resources/js/jquery.splitter-0.14.0.js"></script>
<script type="text/javascript" src="./resources/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
<link rel="stylesheet" href="./resources/css/pure-css-select-style.css">

<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

<title>tenasia</title>
<style>

.wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
}

#content {
    width: 100%;
    padding: 20px;
    min-height: 100vh;
    transition: all 0.3s;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    background: #7386D5;
    color: #fff;
    transition: all 0.3s;
}

@media (max-width: 1020px) {
    #sidebar {
        margin-right: -250px;
    }
}

</style>
</head>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var body = $("html, body");
    body.stop().animate({scrollTop:0}, 500, 'swing', function(){});
});
</script>
<body>
    <div style="width:1020px; margin: 0px auto;">
        <div class="wrapper">
            <div id="content">
            </div>
            <nav id="sidebar">
            </nav>
        </div>
    </div>
</body>
</html>
