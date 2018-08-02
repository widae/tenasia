<?php 
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $type = $_GET['type'] == null ? 0 : $_GET['type'];
    $notice_id = $_GET['id'] == null ? 0 : $_GET['id'];
    $currPage = $_GET['currPage'] == null ? 0 : $_GET['currPage'];
    $currBlock = $_GET['currBlock'] == null ? 0 : $_GET['currBlock'];
    $cntPerPage = 10;	// 한 페이지에 보여질 item 수
    $startPage = $currPage == null ? 0 : $currPage * $cntPerPage;	// 시작 페이지 번호(0~)
    $total_count = get_total_count();
    $read_marketview = get_read_marketview();
    $url = "marketview_view_list.php?type=" . $type;
    $paging = get_paging($currPage, count($total_count), $cntPerPage, $currBlock, 'marketview_view_list.php');
    
    function get_total_count()
    {
        global $mysqli, $id;
        $sql = "SELECT * FROM marketview";
        $rows = get_rows($mysqli, $sql);
        
        return $rows;
    }
    function get_read_marketview()
    {
        global $mysqli, $currPage, $cntPerPage;
        $curr = $currPage*$cntPerPage;
        $sql = "SELECT * FROM marketview ORDER BY id desc limit $curr, $cntPerPage";
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
		
		<?php include './top_banner.php'; ?>	
						
		<div class="row">
			<div class="container-full">				
				<div style="width:1000px; min-height:700px; margin:0 auto; padding:40px 0;">
					<div class="pure-css-select-style theme-rounded" style="float:left; width:400px">
						<select id="type" name="type">
							<option value="marketView">Market View</option>							
						</select>
					</div>
					
					<script type="text/javascript">
					function checkAll() {
						if($('#checkAll').is(':checked') ) {
							$('input[name=checkRow]').prop("checked", true);
						} else {
							$('input[name=checkRow]').prop("checked", false);
						}
					}
					
					function modify_notice(regist_id) {
						var url = "./marketview_view_modify.php?id=" + regist_id;
						location.href = url;
					}
					
					function deleteRows() {							
						if( <?=count($read_marketview) ?> > 0 ) {
							var size = <?=count($read_marketview) ?>;
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
								location.href="./marketview_proc_delete.php?deleteList=" + deleteList;
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
							<div class="notice_cell" style="width:250px;">제목</div>
							<div class="notice_cell" style="width:250px;">내용</div>
							<div class="notice_cell" style="width:150px;">작성일</div>
							<div class="notice_cell" style="width:150px;">수정일</div>
							<div class="notice_cell" style="width:150px;">삭제일</div>							
						</div>
						
						<?php 
						if(count($total_count) > 0){
						$i=0;
						foreach($read_marketview as $items):
    						$list_title = $items['title'];
    						$list_contents = $items['link_url'];
    						$list_title = (mb_strlen($list_title,'utf-8') > 20) ? mb_substr($list_title, 0, 20, 'utf-8') . "..." : $list_title;
    						$list_contents = (mb_strlen($list_contents,'utf-8') > 20) ? mb_substr($list_contents, 0, 20, 'utf-8') . "...": $list_contents;			
						?>
						<div class="notice_row" style="height:50px;">
							<div class="notice_cell text-center">
								<input type="checkbox" value=<?=$items['id'] ?>
									name="checkRow" id="checkRow_<?=$i ?>" onClick="chkOnly1(this);">
							</div>
							<div class="notice_cell text-center">
								<?=$items['id'] ?>
							</div>
							<div class="notice_cell">
								<a href="./marketview_view_modify.php?type=<?=$type ?>&id=<?=$items['id'] ?>">
									<?=$list_title ?>
								</a>
							</div>
							<div class="notice_cell"><?=$list_contents ?></div>
							<div class="notice_cell text-center"><?=$items['created_time'] ?></div>
							<div class="notice_cell text-center"><?=$items['modified_time'] ?></div>
							<div class="notice_cell text-center"><?=$items['deleted_time'] ?></div>							
						</div>
						<?php 
						$i++;
						endforeach;
						}
						?>		
					</div> <!-- notice_table -->
					<div style="width:100%; text-align:right;">
						<a href="./marketview_view_write.php?type=<?=$type ?>">글작성</a>
					</div>
					<div style="width:500px; margin:0 auto; text-align:center;">
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
		
		<!-- footer -->
		<?php include '../navigation/footer.php'; ?>
	</div> <!-- wrap -->
</body>
</html>