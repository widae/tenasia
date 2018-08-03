<?php header('Content-Type: text/html; charset=UTF-8');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link href="../resources/css/default.css" rel="stylesheet" type="text/css">

<title>Tenasia Admin</title>

<style type="text/css">

</style>
</head>
<body>
	<div id="wrap">

		<div class="row">
			<div class="container-full text-center vertical-middle_div" style="background-color:#373737; font-size:20px; color:#fff; height:150px;">
				<div style="margin:0 auto;">관리자 전용 페이지 입니다.</div>
			</div>
		</div>

		<script language="javascript">
			function hideImage(target) {
				target.style.backgroundImage = "none";
			}
			function changeColor(item){
				$('#'+item).css("color","black");
			}
			function chkLoginValid() {
				if (document.loginForm.user_id.value == "" || document.loginForm.user_id.value=="ID") {
					alert("아이디를 입력하세요.");
					document.loginForm.user_id.focus();
					return false;
				}
				if (document.loginForm.user_pw.value == "" || document.loginForm.user_id.value=="password") {
					alert("비밀번호를 입력하세요.");
					document.loginForm.user_pw.focus();
					return false;
				}
				return true;
			}

		</script>

		<div class="row" style="height:500px;">
			<div class="container">
				<div style="width:800px; margin: 0 auto; padding-top:100px;">
					<form name="loginForm" method="post" onsubmit="return chkLoginValid();" action="./loginProc.php">
						<table style="width:400px; margin:auto;" >
							<tr height="26px">
								<td width="100px" style="text-align:right;">
									<div style="margin-right:20px;">ID</div>
								</td>
								<td>
									<input type="text" id="user_id" name="user_id" placeholder="아이디를 입력하세요" tabindex="1" onFocus="javascript:this.value=''" style="width:150px;" autofocus/>
								</td>
								<td rowspan="2">
									<input type="image" src="../resources/img/login/btn_login.png"  tabindex="3" style="width:120px;">
								</td>
							</tr>
							<tr height="26px">
								<td width="100px" style="text-align:right;">
									<div style="margin-right:20px;">비밀번호</div>
								</td>
								<td>
									<input type="password" id="user_pw" name="user_pw" placeholder="비밀번호를 입력하세요"  tabindex="2" onFocus="javascript:this.value=''" style="width:150px;" />
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- wrap -->
</body>
</html>
