<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $deleteList = $_GET['deleteList'] == null ? 0 : $_GET['deleteList'];
    $id = explode("/", $deleteList);
    $delete_investmentinsight = set_deleted($id);
    
    function get_delete_investmentinsight($id)
    {
        global $mysqli;
        $sql = "UPDATE investmentinsight SET is_deleted=1, deleted_time=now() WHERE id= $id";
        $result = $mysqli->query($sql);
        
        return $result;
    }
    function set_deleted($id){
        foreach ($id as $items) :
            get_delete_investmentinsight($items);
        endforeach;
    }
    
    $mysqli->close();
?>
	<script type="text/javascript">
<?php 
if($deleteList != 0){
    $delete_investmentinsight
?>
	alert("삭제되었습니다.");
	location.href = "./investmentinsight_view_list.php";
<?php 
} else {
?>
	alert("삭제 실패");
	history.back(-1);	
<?php 
}
?>
	</script>