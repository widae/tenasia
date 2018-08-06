<?php

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
<meta name="viewport" content="width=1020">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="./resources/css/default.css" rel="stylesheet" type="text/css">
<link href="./resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./resources/js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="./resources/js/jquery.splitter-0.14.0.js"></script>
<script type="text/javascript" src="./resources/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
<link rel="stylesheet" href="./resources/css/pure-css-select-style.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<title>tenasia</title>
</head>
<script type="text/javascript">
jQuery(document).ready(function($) {
    // scroll(animate) to taget
    $(".scroll").click(function(event){
        $( 'html, body' ).stop().animate( { scrollTop : '0' } );
    });
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
                <hr style="width:800px; margin:0px auto;"/>
                <!-- body -->
                <div class="container">
                    <!-- main -->
                    <div class="container">
                    <?php
                        if($numberOfRows > 0) {
                            foreach($articles as $article):

                                $created_time = date("F j, Y", strtotime($article['created_time']));

                                $mainImage;
                                $imageUrls = explode(',', $article['images']);
                                $numberOfUrls = count($imageUrls);
                                $mainImage = $imageUrls[0];


                                // RE!!!
                                $plain = getplaintextintrofromhtml($article['content'], 100);
                                $intro = replaceNbsp($plain);

                    ?>
                        <div class="container" style="width:100%; padding:0px 70px">
                            <div class="section_title_dark" style="font-size:50px; word-wrap:break-word;" >
                                <?=$article['subject']?>
                            </div>
                            <div class="dateSection">
                                <?=$created_time ?>
                            </div>
                            <div class="mainImageSection">
                                <img class="mainImage" src="<?=$mainImage ?>" alt="article image"/>
                            </div>
                            <div class="section_subexplain" style="font-size:25px; padding-top:7px">
                                <?=$intro ?>
                            </div>
                            <div style="margin: 70px 0px;">
                                <a class="btn btn-primary" role="button" style="border-radius:25px;"
                                    href="<?=$root?>/detail_mobile.php?id=<?=$article['id']?>">
                                    Подробнее...
                                </a>
                            </div>
                            <!--
                            <div id="detail_link">
                                <a href="<?=$root?>/detail_mobile.php?id=<?=$article['id']?>">
                                    Подробнее...
                                </a>
                            </div>
                            -->
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
                </div>
            </div>
        </div>
    </div><!-- end of wrap -->
</body>
</html>
