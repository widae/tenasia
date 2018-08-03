<?php

    session_start();
    if ( !isset( $_SESSION['user_id'] ) ) {
        header("Location: http://localhost/tenasia/login/login.php");
    }

    header('Content-Type: text/html; charset=UTF-8');

    require_once('../common.php');

    $mysqli = DBConnect();

    $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 0;
    $deleteList = isset($_GET['deleteList']) && !empty($_GET['deleteList']) ? $_GET['deleteList'] : 0;
    $id_array = explode("/", $deleteList);
    $delete_notice = set_deleted($id_array);

    function set_deleted($id_array){
        foreach ($id_array as $item) :
        get_delete_notice($item);
        endforeach;
    }

    function get_delete_notice($id)
    {
        global $mysqli;
        // $sql = "UPDATE notice SET is_deleted=1, deleted_time=now() WHERE id= $id";
        // $sql = "UPDATE article SET is_deleted=1, deleted_time=now() WHERE id= $id";
        $sql =  "DELETE FROM article WHERE id = $id";
        $result = $mysqli->query($sql);

        return $result;
    }

    $mysqli->close();
?>
	<script type="text/javascript">
<?php
if($deleteList != 0){
    $delete_notice
?>
	alert("삭제되었습니다.");
	location.href = "./notice_view_list.php?type=<?=$type?>";
<?php
} else {
?>
	alert("삭제 실패");
	history.back(-1);
<?php
}
?>
	</script>
