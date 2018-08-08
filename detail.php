<?php

    require_once('./common.php');

    $mysqli = DBConnect();

    $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : null;
    $article = null;
    if($id != null){
        $article = getArticleById($id);
    }

    $rightSideArticles = getRightSideArticles();
    $numOfRightSideArticles = getNumOfRightSideArticles();

    function getArticleById($id){
        global $mysqli;
        $sql = "SELECT * FROM article WHERE id = $id";
        $rows = get_rows($mysqli, $sql);
        $row_cnt = count($rows);
        if($row_cnt > 0){
            return $rows[0];
        }else{
            return null;
        }
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
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
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

        <div class="container" style="margin: 20px 0px 0px; padding: 0px 5%;">
            <div class="wrapper">
                <div id="content" style="padding: 0px">
                <?php
                    if($article != null) {
                        $created_time = date("F j, Y", strtotime($article['created_time']));
                ?>
                    <div class="container" style="width:100%;">
                        <div class="section_title_dark" style="font-size:50px; font-weight:bold; word-wrap:break-word;" >
                            <?=$article['subject']?>
                        </div>
                        <div class="dateSection">
                            <?=$created_time?>
                        </div>
                        <div class="section_subexplain" style="padding-top:50px">
                             <?=$article['content']?>
                        </div>
                        <div>
                            <div class="snsIconSection">
                                <a href="https://vk.com/id475629287" target="_blank">
                                    <img class="mainImage" src="./resources/img/detail/vk_icon.png" alt="vk icon"/>
                                </a>
                            </div>
                            <div class="snsIconSection">
                                <a href="https://www.facebook.com/people/Tenasia-Russia/100023034790030" target="_blank">
                                    <img class="mainImage" src="./resources/img/detail/facebook_icon.png" alt="vk icon"/>
                                </a>
                            </div>
                            <div class="snsIconSection">
                                <a href="https://www.instagram.com/tenasiarussia/" target="_blank">
                                    <img class="mainImage" src="./resources/img/detail/instagram_icon.png" alt="vk icon"/>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
                </div>
                <nav id="detail_sidebar">
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

         <?php
            if($numOfRightSideArticles > 0) {
                foreach($rightSideArticles as $rightSideArticle):
                    $id = $rightSideArticle['id'];
                    $created_time = date("F j, Y", strtotime($rightSideArticle['created_time']));
                    $mainImage;
                    $imageUrls = explode(',', $rightSideArticle['images']);
                    $numberOfRows = count($imageUrls);
                    $mainImage = $imageUrls[0];
        ?>
        <div id="bottomNav">
            <div id="bottom_link" class="section_title_dark" >
                <a href="<?=$root?>/detail_mobile.php?id=<?=$id?>">
                    <?=$rightSideArticle['subject']?>
                </a>
            </div>
            <div style="font-size:25px; color:#000000;">
                <?=$created_time ?>
            </div>
            <div class="mainImageSection">
                <a href="<?=$root?>/detail_mobile.php?id=<?=$id?>">
                    <img class="img-thumbnail" style="padding:10px; box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);" src="<?=$mainImage ?>" alt="article image"/>
                </a>
            </div>
        </div>
        <?php
                endforeach;
            }
        ?>
    </div><!-- end of wrap -->
</body>
</html>
