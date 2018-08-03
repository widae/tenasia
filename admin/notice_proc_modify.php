<?php

    session_start();
    if ( !isset( $_SESSION['user_id'] ) ) {
        header("Location: http://localhost/tenasia/login/login.php");
    }

    header('Content-Type: text/html; charset=UTF-8');

    require_once('../common.php');

    $mysqli = DBConnect();

    $id = $_POST['notice_id'];
    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $update_marketview = get_update_marketview();

    function get_update_marketview()
    {
        global $mysqli, $title, $contents, $id;

        $htmlContent = $contents;

        preg_match_all('/<img[^>]+>/i',$htmlContent, $imgTags);
        for ($i = 0; $i < count($imgTags[0]); $i++) {
            preg_match('/src="([^"]+)/i',$imgTags[0][$i], $imgage);
            $origImageSrc[] = str_ireplace( 'src="', '',  $imgage[0]);
        }

        $commaSeparated = implode(",", $origImageSrc);

        $sql = "UPDATE article SET subject='$title', content='$contents', images='$commaSeparated', modified_time=now() WHERE id=$id";
        $result = $mysqli->query($sql);

        return $result;
    }

    $mysqli->close();
?>
	<script type="text/javascript">
<?php
if($update_marketview){
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
