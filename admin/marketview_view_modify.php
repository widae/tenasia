<?php 
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $type = $_GET['type'] == null ? "" : $_GET['type'];
    $notice_id = $_GET['id'] == null ? 0 : $_GET['id'];
    $read_marketview = get_read_marketview();
    
    function get_read_marketview()
    {
        global $mysqli, $notice_id;
        $sql = "SELECT * FROM marketview WHERE id = $notice_id";
        $row = get_row($mysqli, $sql);
        
        return $row;
    }
    
    $mysqli->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link href="../resources/css/default.css" rel="stylesheet" type="text/css">
<link href="../resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../resources/js/jquery-3.2.1.js"></script>

<script type="text/javascript" src="../resources/js/jquery.splitter-0.14.0.js"></script>

<!-- smarteditor2를 사용하기 위한 스크립트 추가 -->
<script type="text/javascript" src="../resources/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<!-- selectbox style -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
<link rel="stylesheet" href="../resources/css/pure-css-select-style.css">

<title>AndBeyondCapitalManagement</title>

<style type="text/css">

</style>
</head>
<body>
	<div id="wrap" class="notice">
	
		<!-- header -->
		<?php include '../navigation/header.php'; ?>
		
		<div class="row">
			<div class="container-full text-center vertical-middle_div" style="background-color:#373737; font-size:20px; color:#fff; height:100px;">
				<div style="margin:0 auto;">관리자 전용 페이지 입니다.</div>
			</div>
		</div>			
						
		<div class="row">
			<div class="container-full" style="width:100%; min-height:700px;">				
				<div style="width:1000px; margin:0 auto; padding-top:20px;">			
					<form id="modify_regist_form" name="modify_regist_form" method="post" action="./marketview_proc_modify.php">
						<div class="pure-css-select-style theme-rounded" style="margin-left:150px; width:400px;">
							<select id="type" name="type">
								<option value="marketView">Market View</option>
							</select>
						</div>
									
						<div class="row" style="padding-bottom:80px;">							
							<div style="width:900px; margin:0 auto;">				
								<div class="row">
									<div style="margin-left:100px;">
										<input type="hidden" name="notice_id" id="notice_id" value="<?=$notice_id ?>"/>
										<div style="margin-top:30px;">
											제목
										</div>
										<div>
								    		<input type="text" name="title" id="title" placeholder="제목을 입력하세요."
								    			style="width:700px;" value="<?=$read_marketview['title']?>">
										</div>
										<div style="margin-top:30px;">
											URL
										</div>
										<div>
											<input type="text" name="link_url" id="link_url" placeholder="링크(url)을 입력하세요."
												style="width:700px;" value="<?=$read_marketview['link_url']?>">
										</div>									
										
									</div>
								</div>
								
								<div class="row">
									<div style="float:right; margin-top:20px; margin-right:30px;">
										<input type="button" id="btn_modify" value="수정"/>
										<input type="button" id="btn_cancel" value="취소" onClick="javascript:history.back(-1);"/>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
		$(document).ready(function() {"WebContent/admin/notice_proc_modify.php"
			$('#btn_modify').click(function() {
				$('#modify_regist_form').submit();
			});
		});		
		</script>
		
		<!-- footer -->
		<?php include '../navigation/footer.php'; ?>
	</div> <!-- wrap -->
</body>
</html>