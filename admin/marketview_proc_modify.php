<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $id = $_POST['notice_id'];
    $title = $_POST['title'];
    $link_url = $_POST['link_url']  == null ? 0 : $_POST['link_url'];
    $update_marketview = get_update_marketview();
    
    function get_update_marketview()
    {
        global $mysqli, $title, $link_url, $id;
        $sql = "UPDATE marketview SET title='$title', link_url='$link_url', modified_time=now() WHERE id=$id";
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