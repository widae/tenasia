<?php 
header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $notice_id = $_POST['notice_id'] == null ? 0 : $_POST['notice_id'];
    $max = 10 * 1024 * 1024;
    
    $uploads_dir = "../upload_file";
    $allowed_ext = array('jpg','jpeg','png','gif');
    
    // 변수 정리
    $error = $_FILES['myfile']['error'];
    $name = $_FILES['myfile']['name'];
    $ext = array_pop(explode('.', $name));
    
    // 오류 확인
    if( $error != UPLOAD_ERR_OK ) {
        switch( $error ) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "파일이 너무 큽니다. ($error)";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "파일이 첨부되지 않았습니다. ($error)";
                break;
            default:
                echo "파일이 제대로 업로드되지 않았습니다. ($error)";
        }
        exit;
    }
    
    // 확장자 확인
    if( !in_array($ext, $allowed_ext) ) {
        echo "허용되지 않는 확장자입니다.";
        exit;
    }
    
    // 파일 이동
    move_uploaded_file( $_FILES['myfile']['tmp_name'], "$uploads_dir/$name");
    
    $update_photo = get_update_photo($name, $id);
    
    function update_photo($name, $id)
    {
        global $mysqli;
        $sql = "UPDATE investmentinsight SET main_photo = '$name' WHERE id= $id";
        $result = $mysqli->query($sql);
        
        return $result;
    }
    
    $mysqli->close();
?>
	<script type="text/javascript">
<?php 
if($update_photo){
?>
	alert("등록되었습니다.");	
	close();
<?php 
} else {
?>
	alert("등록 실패\n" + <?=$uploads_dir?>);
	close();
<?php 
}
?>
	</script>