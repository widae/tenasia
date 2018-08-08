<?php

    //require_once('./detector.php');
    require_once('./common.php');

    $mysqli = DBConnect();

    $currPage = isset($_GET['currPage']) && !empty($_GET['currPage']) ? $_GET['currPage'] : 0;
    $currBlock = isset($_GET['currBlock']) && !empty($_GET['currBlock']) ? $_GET['currBlock'] : 0;
    $cntPerPage = 2;   // 한 페이지에 보여질 item 수
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
<meta name="viewport" content="width=1020, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="./resources/css/default.css" rel="stylesheet" type="text/css">
<title>tenasia</title>
</head>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var body = $("html, body");
    body.stop().animate({scrollTop:0}, 500, 'swing', function(){});
});
</script>
<body>
    <div id="wrap">
        <?php include './header.php'; ?>

        <hr style="width:1000px; margin: 50px auto 0px auto;"/>

        <div class="container" style="margin: 20px auto 0px auto; padding: 0px 10px;">
            <div class="wrapper">
                <div id="content">
                <?php
                    if($numberOfRows > 0) {
                        foreach($articles as $article):
                            $id = $article['id'];
                            $created_time = date("F j, Y", strtotime($article['created_time']));
                            $mainImage;
                            $imageUrls = explode(',', $article['images']);
                            $numberOfUrls = count($imageUrls);
                            $mainImage = $imageUrls[0];
                            $plain = getplaintextintrofromhtml($article['content'], 100);
                            $intro = replaceNbsp($plain);
                ?>
                    <div class="container" style="width:100%;">
                        <div id="main_link" class="section_title_dark">
                            <a href="<?=$root?>/detail.php?id=<?=$id?>">
                                <?=$article['subject']?>
                            </a>
                        </div>
                        <div class="dateSection">
                            <?=$created_time ?>
                        </div>
                        <div class="mainImageSection">
                            <a href="<?=$root?>/detail.php?id=<?=$id?>">
                                <img class="mainImage" src="<?=$mainImage ?>" alt="article image"/>
                            </a>
                        </div>
                        <div class="section_subexplain" style="padding-top:7px">
                            <?=$intro ?>
                        </div>
                        <div id="detail_link">
                            <a href="<?=$root?>/detail.php?id=<?=$article['id']?>">
                                Подробнее...
                            </a>
                        </div>
                    </div>
                <?php
                        endforeach;
                    }
                ?>
                    <div id="page_link">
                        <?=$paging ?>
                    </div>
                </div><!-- end of content -->
                <nav id="sidebar">
                <?php
                    if($numOfRightSideArticles > 0) {
                        foreach($rightSideArticles as $rightSideArticle):
                            $id = $rightSideArticle['id'];
                            $created_time = date("F j, Y", strtotime($rightSideArticle['created_time']));
                            $mainImage;
                            $imageUrls = explode(',', $rightSideArticle['images']);
                            $numberOfUrls = count($imageUrls);
                            $mainImage = $imageUrls[0];

                ?>
                    <div class="container" style="width:100%; margin: 12px 0px;">
                        <div style="width:30%; float:left;">
                            <a href="<?=$root?>/detail.php?id=<?=$id?>">
                                <img class="mainImage" src="<?=$mainImage ?>" alt="article image"
                                    style="width:100%"/>
                            </a>
                        </div>
                        <div style="width:70%; height:100px; float:left; padding: 0px 5px;">
                            <div id="side_link">
                                <a href="<?=$root?>/detail.php?id=<?=$id?>">
                                    <?=$rightSideArticle['subject']?>
                                </a>
                            </div>
                            <div style="height:30%; font-size:3px;">
                                <?=$created_time ?>
                            </div>
                        </div>
                    </div>
                <?php
                        endforeach;
                    }
                ?>
                </nav>
            </div><!-- end of wrapper -->
        </div><!-- end of container -->
    </div><!-- end of wrap -->
</body>
</html>
