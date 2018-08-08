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
<title>tenasia</title>
<style>

#side_link { height: 70%; font-size: 10px; }
#side_link a, a:active, a:visited { text-decoration:none; color:#000000; background-color:#ffffff;}
#side_link a:hover { font-size:10px; text-decoration:underline; color:#000000; }

#main_link { font-size:25px; word-wrap:break-word; }
#main_link a, a:active, a:visited { text-decoration:none; color:#000000; background-color:#ffffff;}
#main_link a:hover { font-size:25px; font-weight:500; text-decoration:underline; color:#000000; }

#page_link { text-align:center; padding:55px 0px; }

#page_link a:link, a:visited {
    display: inline;
    font-size:15px;
    text-align: center;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    background-color: #800080;
    border-radius: 30px;
    margin: 40px 5px;
}

#page_link a:hover, a:active {
    background-color: #00498c;
    font-size:15px;
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
    <div id="wrap">
    <!-- width: 100%; min-width:1020px; -->
    <!-- width = P.W or 1020px -->
        <div class="container-full">
        <!-- width: 100%; margin: 0 auto; -->
                <?php include './header.php'; ?>
                <!-- separator-->
                <hr style="width:1000px; margin: 50px auto 0px auto;"/>
                <!-- body -->
                <div class="container" style="margin-top: 20px; padding: 0px 10px;">
                    <!-- main -->
                    <div class="container" style="width:65%; float:left;">
                    <?php
                        if($numberOfRows > 0) {
                            foreach($articles as $article):

                                $id = $article['id'];

                                $created_time = date("F j, Y", strtotime($article['created_time']));

                                $mainImage;
                                $imageUrls = explode(',', $article['images']);
                                $numberOfUrls = count($imageUrls);
                                $mainImage = $imageUrls[0];


                                // RE!!!
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
                            <!--
                            <div class="btn_detail" style="padding: 14px 0px;">
                                <a href="http://localhost/tenasia/detail.php?id=<?=$article['id']?>">
                                    <img src="./resources/img/main/btn_abcm_product_detail.png" alt="detail button"
                                        style="width:89px; height:30px;"/>
                                </a>
                            </div>
                            -->
                            <div id="detail_link">
                                <a href="<?=$root?>/detail.php?id=<?=$article['id']?>">
                                    Подробнее...
                                </a>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    ?>
                        <!--
                        <div id="paging" style="text-align:center; padding:55px 0px;">
                            <?=$paging ?>
                        </div>
                        -->
                        <div id="page_link">
                            <?=$paging ?>
                        </div>
                    </div>
                    <!-- main -->
                    <?php
                        }else{
                    ?>
                    <div class="container text-center" style="padding-top:40px; font-size:25px; color:#373737;">등록된 공지사항이 존재하지 않습니다.</div>
                    <?php
                        }
                    ?>
                    <div style="width:35%; padding: 0px 0px 0px 25px; margin:0px; float:left;">
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
                            <div style="width:35%; float:left;">
                                <a href="<?=$root?>/detail.php?id=<?=$id?>">
                                    <img class="mainImage" src="<?=$mainImage ?>" alt="article image"
                                        style="width:100%"/>
                                </a>
                            </div>
                            <div style="width:65%; height:100px; float:left; padding: 0px 5px;">
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
                    ?>
                    </div>
                    <?php
                        }else{
                    ?>
                    <div style="width:340px; margin:0px; float:left;">
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div><!-- end of wrap -->
</body>
</html>
