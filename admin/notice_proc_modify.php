<?php
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');

    $mysqli = DBConnect();

    $id = $_POST['notice_id'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $link_url = $_POST['link_url']  == null ? 0 : $_POST['link_url'];
    $update_marketview = get_update_marketview();

    function get_update_marketview()
    {
        global $mysqli, $type, $title, $contents, $link_url, $id;

        $htmlContent = $contents;
        preg_match_all('/<img[^>]+>/i',$htmlContent, $imgTags);
        for ($i = 0; $i < 1; $i++) {
            // get the source string
            preg_match('/src="([^"]+)/i',$imgTags[0][$i], $imgage);
            // remove opening 'src=' tag, can`t get the regex right
            $origImageSrc[] = str_ireplace( 'src="', '',  $imgage[0]);
        }


        //$sql = "UPDATE notice SET type='$type', title='$title', contents='$contents', link_url='$link_url', modified_time=now() WHERE id=$id";
        $sql = "UPDATE article SET subject='$title', content='$contents', images='$origImageSrc[0]', modified_time=now() WHERE id=$id";
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
	location.href = "./notice_view_list.php?type=<?=$type?>";
<?php
} else {
?>
	alert("등록 실패");
	history.back(-1);
<?php
}
?>
	</script>
