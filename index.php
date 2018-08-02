<?php

    require_once('./common.php');

    $mysqli = DBConnect();

    $currPage = isset($_GET['currPage']) && !empty($_GET['currPage']) ? $_GET['currPage'] : 0;
    $currBlock = isset($_GET['currBlock']) && !empty($_GET['currBlock']) ? $_GET['currBlock'] : 0;
    $cntPerPage = 7;   // 한 페이지에 보여질 item 수
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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="./resources/css/default.css" rel="stylesheet" type="text/css">
<link href="./resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./resources/js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="./resources/js/jquery.splitter-0.14.0.js"></script>
<script type="text/javascript" src="./resources/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
<link rel="stylesheet" href="./resources/css/pure-css-select-style.css">
<title>tenasia</title>
</head>

<body>
    <div id="wrap">
    <!-- width: 100%; min-width:1020px; -->
    <!-- width = P.W or 1020px -->
        <div class="container-full">
        <!-- width: 100%; margin: 0 auto; -->
                <?php include './header.php'; ?>
                <!-- separator-->
                <hr style="width:1000px; margin:0px auto;"/>
                <!-- body -->
                <div class="container">
                    <!-- main -->
                    <div class="container" style="width:65%; float:left;">
                    <?php
                        if($numberOfRows > 0) {
                            foreach($articles as $article):

                                $created_time = date("F j, Y", strtotime($article['created_time']));

                                $mainImage;
                                $imageUrls = explode(',', $article['images']);
                                $numberOfRows = count($imageUrls);
                                if($numberOfRows > 0){
                                    $mainImage = $article['images'];
                                }else{
                                    $mainImage = $imageUrls[0];
                                }

                                // RE!!!
                                $plain = getplaintextintrofromhtml($article['content'], 100);
                                $intro = replaceNbsp($plain);

                    ?>
                        <div class="container" style="width:100%;">
                            <div class="section_title_dark" style="font-size:25px; word-wrap:break-word;" >
                                <?=$article['subject']?>
                            </div>
                            <div class="dateSection">
                                <?=$created_time ?>
                            </div>
                            <div class="mainImageSection">
                                <img class="mainImage" src="<?=$mainImage ?>" alt="article image"/>
                            </div>
                            <div class="section_subexplain" style="padding-top:7px">
                                <?=$intro ?>
                            </div>
                            <div class="btn_detail" style="padding: 14px 0px;">
                                <a href="http://localhost/tenasia/detail.php?id=<?=$article['id']?>">
                                    <img src="./resources/img/main/btn_abcm_product_detail.png" alt="detail button"
                                        style="width:89px; height:30px;"/>
                                </a>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    ?>
                        <div id="paging" style="text-align:center; padding:55px 0px;">
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
                    <div style="width:35%; padding: 0px 0px 0px 15px; margin:0px; float:left;">
                    <?php
                        if($numOfRightSideArticles > 0) {
                            foreach($rightSideArticles as $rightSideArticle):

                                $created_time = date("F j, Y", strtotime($rightSideArticle['created_time']));

                                $mainImage;
                                $imageUrls = explode(',', $rightSideArticle['images']);
                                $numberOfRows = count($imageUrls);
                                if($numberOfRows > 0){
                                    $mainImage = $rightSideArticle['images'];
                                }else{
                                    $mainImage = $imageUrls[0];
                                }

                    ?>
                        <div class="container" style="width:100%; margin: 12px 0px;">
                            <div style="width:35%; float:left;">
                                <img class="mainImage" src="<?=$mainImage ?>" alt="article image"
                                    style="width:100%"/>
                            </div>
                            <div style="width:65%; height:100px; float:left; padding: 0px 5px;">
                                <div style="height:70%; font-size:10px;">
                                    <?=$rightSideArticle['subject']?>
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
