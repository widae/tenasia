<?php 
    require_once('../common.php');
    
    $mysqli = DBConnect();
    
    $type = $_GET['type'] == null ? "notice" : $_GET['type'];
    $notice_id = $_GET['id'] == null ? 0 : $_GET['id'];
    $currPage = $_GET['currPage'] == null ? 0 : $_GET['currPage'];
    $currBlock = $_GET['currBlock'] == null ? 0 : $_GET['currBlock'];
    $cntPerPage = 2;	// 한 페이지에 보여질 item 수
    $startPage = $currPage == null ? 0 : $currPage * $cntPerPage;	// 시작 페이지 번호(0~)
    $total_count = get_total_count();
    $read_notice = get_read_notice();
    $url = "regist_view.php";
    $paging = get_paging($currPage, count($total_count), $cntPerPage, $currBlock, $url);
    
    function get_total_count()
    {
        global $mysqli, $id;
        $sql = "SELECT * FROM notice WHERE";
        $rows = get_rows($mysqli, $sql);
        
        return $rows;
    }
    function get_read_notice()
    {
        global $mysqli, $type, $currPage, $cntPerPage;
        $curr = $currPage*$cntPerPage;
        $sql = "SELECT * FROM notice WHERE type = '$type' AND is_deleted = 0 ORDER BY id desc limit $curr, $cntPerPage";
        $rows = get_rows($mysqli, $sql);
        
        return $rows;
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
			<div class="container-full" id="splitContainer" style="width:100%; min-height:700px;">
				<div class="left_panel" style="width:800px; background-color:#fff;">
					<div style="width:800px; margin:0 auto; padding-top:20px;">
						<div class="" style="float:left; width:400px;">
							<select id="type" name="type">
								<option value="notice">공지사항</option>
								<option value="research">보도자료</option>
								<option value="faq">FAQ</option>
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
							var url = "./regist_view.php?type=" + "<?=$type?>" + "&id=" + regist_id;
							location.href = url;
						}
						
						function deleteRows() {							
							if( <%=noticeDTOList.size() %> > 0 ) {
								var size = <%=noticeDTOList.size() %>;
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
									for(var j=0; j<d_obj.length; j++) {
										if(d_obj[j].checked == true) {
											alert(d_obj[j].value);			
										}
									}
								}
							}
						}
						</script>
						
						<div style="float:left; width:400px; text-align:right;">
							<a href="#" onClick="deleteRows();">
								선택한 목록 삭제&nbsp;&nbsp;
								<img src="../resources/img/icon/icon_delete.png" id="btn_delete" width="12px"/>
							</a>
						</div>
						<div class="notice_table" style="margin-top:20px;">						
							<div id="totice_table_header" class="notice_row header">
								<div class="notice_cell" style="width:10px;">
									<input type="checkbox" name="checkAll" id="checkAll" onClick="checkAll();"/>
								</div>
								<div class="notice_cell" style="width:55px;">ID</div>
								<div class="notice_cell" style="width:240px;">제목</div>
								<div class="notice_cell" style="width:240px;">내용</div>
								<div class="notice_cell" style="width:100px;">작성일</div>
								<div class="notice_cell" style="width:100px;">수정일</div>
								<div class="notice_cell" style="width:100px;">삭제일</div>
								<div class="notice_cell" style="width:55px;">수정</div>
							</div>
							
							<?php 
							if(count($total_count) > 0){
    						$i=0;
    						foreach ($read_notice as $items) :
        						$list_title = $items['title'];
        						$list_contents = $items['contents'];
        						$list_title = (mb_strlen($list_title,'utf-8') > 20) ? mb_substr($list_title, 0, 20, 'utf-8') . "..." : $list_title;
        						$list_contents = (mb_strlen($list_contents,'utf-8') > 20) ? mb_substr($list_contents, 0, 20, 'utf-8') . "...": $list_contents;			
    						?>
							<div class="notice_row" style="height:50px;">
								<div class="notice_cell text-center">
									<input type="checkbox" value=<?=$items['id'] ?>
										name="checkRow" id="checkRow_<?=$i ?>" onClick="chkOnly1(this);">
								</div>
								<div class="notice_cell text-center"><?=$items['id'] ?></div>
								<div class="notice_cell"><?=$list_title ?></div>
								<div class="notice_cell"><?=$list_contents ?></div>
								<div class="notice_cell text-center"><?=$items['created_time'] ?></div>
							<div class="notice_cell text-center"><?=$items['modified_time'] ?></div>
							<div class="notice_cell text-center"><?=$items['deleted_time'] ?></div>							
						
									<a href="#" onClick="modify_notice(<?=$items['id'] ?>);">
										<img src="../resources/img/icon/icon_modify.png" width="30px;">
									</a>									
								</div>
							</div>
    						<?php 
    						$i++;
    						endforeach;
							}
    						?>			
						</div> <!-- notice_table -->
						<div style="width:300px; margin:0 auto; text-align:center;">
							<?=$paging ?>
						</div>			
					</div>
				</div> <!-- end of left_panel -->
				
				<div class="right_panel">
					<form id="regist_form" action="./regist_proc.php" method="post">
						<div class="row" style="padding-bottom:80px;">							
							<div style="width:900px; margin:0 auto;">				
								<div class="row">
									<div style="margin-left:100px;">
										<div style="margin-top:30px;">
											제목
										</div>
										<div>
												<?php 
										    	if($notice_id != null || $notice_id == "0") {
										    	?>
										    		<input type="text" name="title" id="title" placeholder="제목을 입력하세요." 
										    			style="width:700px;" value="<?=$total_count['title'] ?>">
										    	<?php 
										    	} else {
										    	?>
										    		<input type="text" name="title" id="title" placeholder="제목을 입력하세요." style="width:700px;">	
										    	<?php 
										    	}
										    	?>
											
										</div>
										<div style="margin-top:20px;">
											내용
										</div>
										<div>
										    <textarea name="smarteditor" id="smarteditor" rows="10" cols="100" style="width:766px; height:412px;">
										    	<?php 
										    	if($notice_id != null || $notice_id == "0") {
										    	    echo ($total_count['contents']);
										    	}
										    	?>
										    </textarea>	
										</div>
									</div>
								</div>
								
								<div class="row">
									<div style="float:right; margin-top:20px; margin-right:30px;">
										<input type="button" id="btn_regist" value="저장"/>
										<input type="button" id="btn_cancel" value="취소"/>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div> <!-- end of right_panel -->
			</div>
		</div>
		
		<script type="text/javascript">
		$(document).ready(function() {
			// splitContainer
			$('#splitContainer').split({orientation:'vertical', limit:100, position:'50%'});
			
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