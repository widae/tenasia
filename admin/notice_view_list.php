<?php

	require_once('../common.php');

	session_start();
    if ( !isset( $_SESSION['user_id'] ) ) {
        header("Location: $root/login/login.php");
    }

    $mysqli = DBConnect();

    $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : "notice";

    $currPage = isset($_GET['currPage']) && !empty($_GET['currPage']) ? $_GET['currPage'] : 0;
    $currBlock = isset($_GET['currBlock']) && !empty($_GET['currBlock']) ? $_GET['currBlock'] : 0;
    $cntPerPage = 1;	// 한 페이지에 보여질 item 수

    $numberOfRows = getNumberOfRows();
    $articles = getArticles();

    //$url = "notice_view_list.php?type=" . $type;
    $url = "notice_view_list.php";

    //$testUrl = "notice_view_list.php?type=" . $type;
     //parse_str($testUrl, $paramArray);
     //if(isset($paramArray['currBlock'])){
	//	$paramArray['currBlock'] = "1";
    //}else{
	//	$testUrl .= "&currBlock=0";
	//}
	//$rdr_str = http_build_query($paramArray);
	//$rdr_str = http_build_query($query_string);


    $paging = get_paging($currPage, $numberOfRows, $cntPerPage, $currBlock, $url);

    function getNumberOfRows()
    {
        global $mysqli, $type;
        $sql = "SELECT COUNT(id) AS numberOfRows FROM article";
        $rows = get_rows($mysqli, $sql);
        return $rows[0]['numberOfRows'];
    }
    function getArticles()
    {
        global $mysqli, $type, $currPage, $cntPerPage;
        $curr = $currPage*$cntPerPage;
       	$sql = "SELECT * FROM article ORDER BY created_time DESC LIMIT $curr, $cntPerPage";
        $rows = get_rows($mysqli, $sql);

        return $rows;
    }

    $mysqli->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes">

<link href="../resources/css/default.css" rel="stylesheet" type="text/css">
<link href="../resources/css/jquery.splitter.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../resources/js/jquery-3.2.1.js"></script>

<script type="text/javascript" src="../resources/js/jquery.splitter-0.14.0.js"></script>

<!-- smarteditor2를 사용하기 위한 스크립트 추가 -->
<script type="text/javascript" src="../resources/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<!-- selectbox style -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css">
<link rel="stylesheet" href="../resources/css/pure-css-select-style.css">

<title>Tenasia Admin</title>

<style type="text/css">

#title_link a, a:active, a:visited {
	font-size: 10px;
	font-weight: bold;
	text-decoration: none;
	color: #000000;
	background-color: none;
}

#title_link a:hover {
	font-size:10px;
	font-weight: bold;
	text-decoration:underline;
	color:#000000;
}

#page_link { text-align:center; padding:55px 0px; }

#page_link a:link, a:visited {
    display: inline;
    font-size:15px;
    text-align: center;
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    background-color: #800080;
    border-radius: 30px;
    margin: 40px 5px;
}

#page_link a:hover, a:active {
    background-color: #00498c;
    font-size:15px;
    font-weight: normal;
}

</style>
</head>
<body>
	<div id="wrap" class="notice">

		<div class="row">
			<div class="container-full text-center vertical-middle_div" style="background-color:#373737; font-size:20px; color:#fff; height:100px;">
				<div style="margin:0 auto;">관리자 전용 페이지 입니다.</div>
			</div>
		</div>

		<div class="row">
			<div class="container-full">
				<div style="width:1000px; min-height:700px; margin:0 auto; padding:40px 0;">

					<script type="text/javascript">
					function checkAll() {
						if($('#checkAll').is(':checked') ) {
							$('input[name=checkRow]').prop("checked", true);
						} else {
							$('input[name=checkRow]').prop("checked", false);
						}
					}

					function modify_notice(regist_id) {
						var url = "./regist_view.php?type=" + "<?=$type?>" + "&id=" + regist_id;
						location.href = url;
					}

					function deleteRows() {
						if( <?=$numberOfRows ?> > 0 ) {
							var size = <?=$numberOfRows ?>;
							var temp = 0;

							for(var i=0; i<size; i++) {
								var obj = document.getElementById("checkRow_" + i);
								if(obj.checked == true) {
									temp++;
									break;
								}
							}

							if(temp == 0) {
								alert("삭제할 데이터를 선택하세요");
							} else {
								var d_obj = document.getElementsByName("checkRow");
								var deleteList = "";
								for(var j=0; j<d_obj.length; j++) {
									if(d_obj[j].checked == true) {
										deleteList = deleteList + d_obj[j].value + "/";
									}
								}
								location.href="./notice_proc_delete.php?type=<?=$type?>&deleteList=" + deleteList;
							}
						}
					}
					</script>

					<div style="float:right; width:50%; line-height:70px; text-align:right;">
						<a href="#" onClick="deleteRows();">
							선택한 목록 삭제
							<img src="../resources/img/icon/icon_delete.png" id="btn_delete" style="width:12px; margin-left:5px;"/>
						</a>
					</div>
					<div class="notice_table" style="margin-top:80px;">
						<div id="totice_table_header" class="notice_row header">
							<div class="notice_cell" style="width:10px;">
								<input type="checkbox" name="checkAll" id="checkAll" onClick="checkAll();"/>
							</div>
							<div class="notice_cell" style="width:60px;">ID</div>
							<!--
							<div class="notice_cell" style="width:250px;">메인 이미지</div>
							-->
							<div class="notice_cell" style="width:250px;">제목</div>
							<div class="notice_cell" style="width:250px;">메인 이미지</div>
							<div class="notice_cell" style="width:500px;">내용</div>
							<div class="notice_cell" style="width:150px;">작성일</div>
							<div class="notice_cell" style="width:150px;">수정일</div>
						</div>
						<?php
						if($numberOfRows > 0){
						    $i=0;
    						foreach($articles as $article) :

        						$subject = $article['subject'];
        						$content = $article['content'];
        						$images = $article['images'];


        						$subject = (mb_strlen($subject,'utf-8') > 20) ? mb_substr($subject, 0, 20, 'utf-8') . "..." : $subject;

        						// Get plain text intro from HTML
	    						$striped = strip_tags($content);
	    						$decoded = html_entity_decode($striped, ENT_QUOTES, 'UTF-8');
	    						$before = mb_substr($decoded, 0, 47, 'UTF-8');
	    						if(strlen($decoded) > 47){
	    							$before .= "…";
	    						}
	    						$string = htmlentities($before, null, 'utf-8');
								$replaced = str_replace("&nbsp;", "<br><br>", $string);
								$intro = html_entity_decode($replaced);

								// Get main image
								$mainImageUrl = explode(',', $article['images'])[0];

						?>
						<div class="notice_row" style="height:50px;">
							<div class="notice_cell text-center">
								<input type="checkbox" value=<?=$article['id']?>
									name="checkRow" id="checkRow_<?=$i ?>" onClick="chkOnly1(this);">
							</div>
							<div class="notice_cell text-center">
								<?=$article['id']?>
							</div>
							<div id="title_link" class="notice_cell">
								<a href="./notice_view_modify.php?type=<?=$type?>&id=<?=$article['id']?>">
									<?=$subject?>
								</a>
							</div>
							<div class="notice_cell">
								<!-- margin:auto 관련 display:block 추가-->
								<a href="./notice_view_modify.php?type=<?=$type?>&id=<?=$article['id']?>">
									<img src="<?=$mainImageUrl?>" alt="main image of the article"
										style="max-width:100%; height:auto; margin:auto; display:block;"/>
								</a>
							</div>
							<div class="notice_cell"><?=$intro?></div>
							<div class="notice_cell text-center"><?=$article['created_time'] ?></div>
							<div class="notice_cell text-center"><?=$article['modified_time'] ?></div>
						</div>
						<?php
						$i++;
						endforeach;
						}
						?>
					</div> <!-- notice_table -->
					<div style="width:100%; text-align:right;">
						<a href="./notice_view_write.php?type=<?=$type ?>">글작성</a>
					</div>
                    <div id="page_link">
                    	<?=$paging ?>
                    </div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		$(document).ready(function() {
			// select change
			var selected_value = $('#type opstion:selected').val()
			$('#type option[value=<?=$type?>]').attr('selected', 'selected');
			$('#type').change(function() {
				var type = $('#type option:selected').val();
				location.href="?type=" + type;
			});

			// smart editor
			var oEditors = [];

			// Editor Setting
			nhn.husky.EZCreator.createInIFrame({
				oAppRef : oEditors, // 전역변수 명과 동일해야 함.
				elPlaceHolder : "smarteditor", // 에디터가 그려질 textarea ID 값과 동일 해야 함.
				sSkinURI : "../resources/smarteditor2/SmartEditor2Skin.html", // Editor HTML
				fCreator : "createSEditor2", // SE2BasicCreator.js 메소드명이니 변경 금지 X
				htParams : {
					// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseToolbar : true,
					// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseVerticalResizer : true,
					// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
					bUseModeChanger : true,
				}
			});

			$('#btn_regist').click(function() {
				oEditors.getById["smarteditor"].exec("UPDATE_CONTENTS_FIELD", []);

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

	</div> <!-- wrap -->
</body>
</html>
