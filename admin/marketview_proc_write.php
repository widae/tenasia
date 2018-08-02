<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $title = $_POST['title'];
    $link_url = $_POST['link_url']  == null ? 0 : $_POST['link_url'];
    $insert_marketview = get_insert_marketview();
    
    function get_insert_marketview()
    {
        global $mysqli, $title, $link_url;
        $sql = "INSERT INTO marketview(title, link_url, created_time) VALUES('$title', '$link_url', now())";
        $result = $mysqli->query($sql);
        
        return $result;
    }
    
    $mysqli->close();
?>
	<script type="text/javascript">
<?php 
if($insert_marketview){
?>
	alert("등록되었습니다.");
	location.href = "./marketview_view_list.php";
<?php 
} else {
?>
	alert("등록 실패");
	history.back(-1);	
<?php 
}
?>
	</script>