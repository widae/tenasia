<?php 
    $notice_id = $_GET['id'] == null ? 0 : $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link href="../resources/css/default.css" rel="stylesheet" type="text/css">
<link href="../resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../resources/js/jquery-3.2.1.js"></script>

<script type="text/javascript" src="../resources/js/jquery.splitter-0.14.0.js"></script>

<title>AndBeyondCapitalManagement</title>

<style type="text/css">

</style>
</head>
<body>
	<div style="padding-top:50px; padding-left:50px;">
	<form action="regist_notice_file_proc.php" method="post" enctype="multipart/form-data">
		<div>
			공지사항 - 파일 업로드
		</div>
		<table style="width:400px; border-collapse:collapse; border:1px solid #e8e8e8;">
			<tr>
				<td>파일: </td>
				<td>
					<input type="hidden" name="notice_id" id="notice_id" value="<?=$notice_id ?>">
					<input type="file" name="attached_file" id="attached_file">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right;">
					<input type="submit" value="전송">
				</td>
			</tr>
		</table>
	</form>
	</div>
</body>
</html>
