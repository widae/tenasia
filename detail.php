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

    $sideDivWidth = 300;
    $containerWidth = 1020 + $sideDivWidth*2;
    $mainDivWidth = $containerWidth - $sideDivWidth*2;

    $containerStyle = 'width:' . $containerWidth . 'px; padding-left:' . $sideDivWidth . 'px;';
    $mainDivStyle = 'width:' . $mainDivWidth . 'px; float:left;';
    $sideDivStyle = 'width:' . $sideDivWidth . 'px; padding-left: 15px; margin:0px; float:left;';

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
                <!--
                <hr style="width:1000px; margin:0px auto;"/>
                -->
                <!-- body -->
                <div class="container" style="<?php echo $containerStyle; ?>">
                    <!-- main -->
                    <div class="container" style="<?php echo $mainDivStyle; ?>">
                    <?php
                        if($article != null) {
                            $created_time = date("F j, Y", strtotime($article['created_time']));
                    ?>
                        <div class="container" style="width:100%;">
                            <div class="section_title_dark" style="font-size:25px; word-wrap:break-word;" >
                                <?=$article['subject']?>
                            </div>
                            <div class="dateSection">
                                <?=$created_time?>
                            </div>
                            <div class="section_subexplain" style="padding-top:7px">
                                 <?=$article['content']?>
                            </div>
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
                    <div style="<?php echo $sideDivStyle; ?>">
                    <?php
                        if($numOfRightSideArticles > 0) {
                            foreach($rightSideArticles as $rightSideArticle):

                                $created_time = date("F j, Y", strtotime($rightSideArticle['created_time']));

                                $mainImage;
                                $imageUrls = explode(',', $rightSideArticle['images']);
                                $numberOfRows = count($imageUrls);
                                $mainImage = $imageUrls[0];

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
