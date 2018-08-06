<?php

        require_once('../common.php');

    session_start();
    if ( !isset( $_SESSION['user_id'] ) ) {
        header("Location: $root/login/login.php");
    }
    header('Content-Type: text/html; charset=UTF-8');

    $mysqli = DBConnect();

    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $insert_notice = get_insert_notice();

    function get_insert_notice()
    {
        global $mysqli, $contents, $title;

        $htmlContent = $contents;

        preg_match_all('/<img[^>]+>/i',$htmlContent, $imgTags);
        for ($i = 0; $i < count($imgTags[0]); $i++) {
            preg_match('/src="([^"]+)/i',$imgTags[0][$i], $imgage);
            $origImageSrc[] = str_ireplace( 'src="', '',  $imgage[0]);
        }

        $commaSeparated = implode(",", $origImageSrc);

       $sql = "INSERT INTO article(subject, content, images) VALUES('$title', '$contents', '$commaSeparated')";


        $result = $mysqli->query($sql);

        echo "$result";

        return $result;
    }

    $mysqli->close();
?>
	<script type="text/javascript">
<?php
if($insert_notice){
?>
	alert("등록되었습니다.");
	location.href = "./notice_view_list.php";
<?php
} else {
?>
	alert("등록 실패");
	history.back(-1);
<?php
}
?>
	</script>
