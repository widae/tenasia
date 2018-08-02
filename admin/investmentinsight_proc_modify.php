<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $id = $_POST['notice_id'];
    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $update_investmentinsight = get_update_investmentinsight();
    
    function get_update_investmentinsight()
    {
        global $mysqli, $title, $contents, $id;
        $sql = "UPDATE investmentinsight SET title='$title', contents='$contents', modified_time=now() WHERE id=$id";
        $result = $mysqli->query($sql);
        
        return $result;
    }
    
    $mysqli->close();
?>
	<script type="text/javascript">
<?php 
if($update_investmentinsight){
?>
	alert("등록되었습니다.");
	location.href = "./investmentinsight_view_list.php";
<?php 
} else {
?>
	alert("등록 실패");
	history.back(-1);	
<?php 
}
?>
	</script>