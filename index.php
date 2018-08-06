<?php

        $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    header('Location: http://192.168.19.55/tenasia/index_mobile.php');

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
                                $numberOfUrls = count($imageUrls);
                                $mainImage = $imageUrls[0];


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
                                $numberOfUrls = count($imageUrls);
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
