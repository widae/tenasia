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
					<form id="regist_form" action="./marketview_proc_write.php" method="post">
						<div class="pure-css-select-style theme-rounded" style="margin-left:150px; width:400px;">
							<select id="type" name="type">
								<option value="marketView">Market View</option>
							</select>
						</div>

						<div class="row" style="padding-bottom:80px;">
							<div style="width:900px; margin:0 auto;">
								<div class="row">
									<div style="margin-left:100px;">
										<div style="margin-top:30px;">
											제목
										</div>
										<div>
											<input type="text" name="title" id="title" placeholder="제목을 입력하세요." style="width:700px;">
										</div>
										<div style="margin-top:30px;">
											URL
										</div>
										<div>
											<input type="text" name="link_url" id="link_url" placeholder="링크(url)을 입력하세요." style="width:700px;">
										</div>
									</div>
								</div>

								<div class="row">
									<div style="float:right; margin-top:20px; margin-right:30px;">
										<input type="button" id="btn_regist" value="저장"/>
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
		$(document).ready(function() {
			$('#btn_regist').click(function() {

				$('#regist_form').submit();
			});
		});

		// 필수값 Check
		function validation(){
			var contents = $.trim(oEditors[0].getContents());
			if(contents === '<p>&bnsp;</p>' || contents === ''){ // 기본적으로 아무것도 입력하지 않아도 값이 입력되어 있음.
				alert("내용을 입력하세요.");
				oEditors.getById['smarteditor'].exec('FOCUS');
				return false;
			}

			return true;
		}
		</script>


		<!-- footer -->
		<?php include '../navigation/footer.php'; ?>
	</div> <!-- wrap -->
</body>
</html>
