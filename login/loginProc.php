<?php
    header('Content-Type: text/html; charset=UTF-8');
    require_once('../common.php');

    $mysqli = DBConnect();

    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $user_info = get_user_info();

    function get_user_info()
    {
        global $mysqli, $user_id, $user_pw;
        $sql = "SELECT user_id, password FROM user WHERE user_id = '$user_id' AND password = '$user_pw'";
        $row = get_row($mysqli, $sql);

        return $row;
    }

    $mysqli->close();
?>
	<script type="text/javascript">
<?php
    if( $user_info != null || $user_info != ""){
        session_start();
        $_SESSION['user_id'] = $user_info['user_id'];;
?>
		location.href="../admin/notice_view_list.php";
<?php
	} else {
?>
		alert("아이디가 존재하지 않거나 비밀번호가 일치하지 않습니다.");
		history.back(-1);
<?php
	}
?>
	</script>
