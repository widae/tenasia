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
	<form action="investmentinsight_proc_image_write.php" method="post" enctype="multipart/form-data">
		<table style="width:400px;">
			<tr>
				<td>파일: </td>
				<td>
					<input type="hidden" name="notice_id" id="notice_id" value="<?=$notice_id ?>">
					<input type="file" name="main_photo" id="main_photo">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right;">
					<input type="submit" value="전송">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>