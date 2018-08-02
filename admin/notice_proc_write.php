<?php
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');

    $mysqli = DBConnect();

    $type = $_POST['type'];
    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $link_url = $_POST['link_url']  == null ? 0 : $_POST['link_url'];
    $insert_notice = get_insert_notice();

    function get_insert_notice()
    {
        global $mysqli, $type, $contents, $title, $link_url;

        $htmlContent = $contents;
        preg_match_all('/<img[^>]+>/i',$htmlContent, $imgTags);
        for ($i = 0; $i < 1; $i++) {
            // get the source string
            preg_match('/src="([^"]+)/i',$imgTags[0][$i], $imgage);
            // remove opening 'src=' tag, can`t get the regex right
            $origImageSrc[] = str_ireplace( 'src="', '',  $imgage[0]);
        }

        //$sql = "INSERT INTO notice(type, title, contents, link_url, created_time) VALUES('$type', '$title', '$contents', '$link_url', now())";
        $sql = "INSERT INTO article(subject, content, images) VALUES('$title', '$contents', '$origImageSrc[0]')";


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
