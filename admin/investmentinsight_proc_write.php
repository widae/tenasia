<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    $contents = $_POST['smarteditor'];
    $insert_investmentinsight = get_insert_investmentinsight();
    
    function get_insert_investmentinsight()
    {
        global $mysqli, $type, $title, $contents;
        $sql = "INSERT INTO investmentinsight(title, contents, created_time) VALUES('$title', '$contents', now())";
        $result = $mysqli->query($sql);
        
        return $result;
    }
    
    $mysqli->close();
?>
	<script type="text/javascript">
<?php 
if($insert_investmentinsight){
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