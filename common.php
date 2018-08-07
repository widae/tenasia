<?php

	require_once('constant.php');

	$JPOST = '';
	$accessToken = '';

	$common_poststatus = !isset($_POST['status']) ? null : $_POST['status'];
	$common_postdata = !isset($_POST['postdata']) ? null : $_POST['postdata'];

	if (isset($common_poststatus))
	{
		if ($common_poststatus == 1) //encrypted
		{
			$common_postdata = decrypt($common_enckey,$common_postdata);
		}

		$JPOST = json_decode($common_postdata);
		$accessToken = empty($JPOST->access_token) ? '' : $JPOST->access_token;

		$is_valid_jpost = is_valid_jpost($JPOST);

		if (!$is_valid_jpost)
		{
			ErrorLog(-10); //json decode fail
		}
	}

	//////////////////////
	function ExitWithRollback($mysqli, $code, $errno = 0)
	{
		$mysqli->query("ROLLBACK");
		ExitWithErrorCode($mysqli, $code, $errno);
	}

	function ExitWithSuccessCode($mysqli, $code, $forcelog = 0)
	{
		$returndata = array("time" => (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), "result" => 1, "code" => $code);
		$jsondata = json_encode($returndata, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		echoe($jsondata, $forcelog);
		$mysqli->close();
		exit();
	}

	function ExitWithSuccessArray($mysqli, $array, $forcelog = 0)
	{
		$jsondata = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		echoe($jsondata,$forcelog);
		$mysqli->close();
		exit();
	}

	function ExitWithErrorCode($mysqli, $code, $errno = 0, $message = '')
	{
		$mysqli->close();
		ErrorLog($code, $errno, $message);
	}

	function ErrorLog($code, $errno = 0, $message = '')
	{
		$errordata['result'] = 0;
		$errordata['code'] = $code;
		$errordata['errno'] = $errno;
		$errordata['message'] = $message;

		$jsondata = json_encode($errordata, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
		echoe($jsondata);

		$db = debug_backtrace();
		exit();
	}

	//////////////////
	function DBConnect()
	{
		global $dbhost, $dbuser, $dbpwd, $dbname;
		$mysqli = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
		$mysqli->query("SET time_zone = 'Asia/Seoul'");
        $mysqli->query("SET NAMES UTF8");
        $mysqli->query("SET SESSION CHARACTER_SET_CONNECTION=utf8;");
        $mysqli->query("SET SESSION CHARACTER_SET_RESULTS=utf8;");
        $mysqli->query("SET SESSION CHARACTER_SET_CLIENT=utf8;");

		if (mysqli_connect_errno())
		{
			ErrorLog(-1000, 0, "DB connection error");//connect error
		}
		return $mysqli;
	}

	function echoe($data, $forcelog = 0)
	{
		if ($forcelog == 1)  // 성공인 경우에도 로그를 남기고 싶은 경우, 상점 거래 등 로그 용량이 커질 수 있으므로 주의해야함..
		{
			$db = debug_backtrace();
		}

		if ($GLOBALS["common_poststatus"] == 1) $data = encrypt($GLOBALS["common_enckey"],$data);
		echo $data;
	}

	function echor($data)  // 배열을 보여주고, 한줄을 뛰운다.
	{
		print_r($data);
		echo "<br>";
	}

	function echot($data,$name = "")  // 테스트로 내용 찍어볼때 사용하려고. 제목과 내용을 보여주고, 한줄을 뛰운다.
	{
		if ($name == "")
		{
			echo $data . "<br>";
		}
		else
		{
			echo $name . ":" . $data . "<br>";
		}
	}

	function get_parameter($parameter, $type = null)
	{
		global $JPOST;

		if (!isset($JPOST->$parameter)) ErrorLog(-300, 0, "패러미터가 없습니다."); // 패러미터 없음

		$value = check_data($JPOST->$parameter, $type);

		return $value;
	}

	///////////////// check varialbe
	function checkData($value, $type = null)
	{
		if ($value === null || $value === "") ErrorLog(-200);	// 비어있는 변수
		if (empty($type)) return $value;
		if (gettype($value) != $type) ErrorLog(-100); // 형식 불일치

		return $value;
	}

	function get_row($mysqli, $sql)
	{
		if ($result = $mysqli->query($sql))
		{
			//var_dump($result);
			if ($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				return $row;
			}
			return null;
		}
		return null;
	}

	function get_rows($mysqli, $sql)
	{
		if ($result = $mysqli->query($sql))
		{
			//var_dump($result);
			if ($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					$rows[] =	$row;
				}
				return $rows;
			}
			return null;
		}

		return null;
	}

	function get_value($mysqli, $sql, $field)
	{
		$row = get_row($mysqli, $sql);
		return $row[$field];
	}

	function encrypt($key, $value)
	{
	    return base64_encode(openssl_encrypt($value, "aes-256-cbc", $key, true, str_repeat(chr(0), 16)));
	}

	function decrypt($key, $value)
	{
    	return openssl_decrypt(base64_decode($value), "aes-256-cbc", $key, true, str_repeat(chr(0), 16));
	}

	function is_valid_jpost($data)
	{
		global $variables;
		if ($data == null || $data == '') return false;

		if (count($data)) return true;

		return true;
	}

//     function today()
//     {
//         return date('Y-m-d');
//     }

//     function day($d = 0)
//     {
//         return date('Y-m-d', strtotime("$d day"));
//     }
	function get_paging($currPage, $totalRecord,$numPerPage,$currBlock, $url) {
	    $total_page = 0;
	    $total_block = 0;
	    $page_per_block =0;
	    $pre_link="";
	    $curr_link="";
	    $next_link="";
	    $link_str="";
	    $before_link="";
	    $after_link="";

	    $total_page =ceil($totalRecord / $numPerPage);
	    $page_per_block = 5;
	    $total_block =ceil($total_page / $page_per_block);

	    if($totalRecord != 0){
	        if($currPage>0){
	            $before_link = "<a style='text-decoration:none; color:#fff;' href=./".$url;
	            if($currPage<$currBlock*$page_per_block)
	                $currBlock--;
	                    $before_link = $before_link . "?currBlock=" . $currBlock;
	                if($currPage>0)
	                    $before_link = $before_link . "&currPage=" . ($currPage-1);
	                    else
	                        $before_link = $before_link . "&currPage=" . $currPage;
	                        //$before_link = $before_link . "><img src='/tenasia/resources/img/notice/btn_prev.png' style='margin-bottom:-4px; width:23px height:23px;'>&nbsp;&nbsp;";
	                    	$before_link = $before_link . ">< Прежняя...";
	        }

	        if($currPage>0){
	            $before_link = $before_link . "</a>";
	        }

	        if(ceil($totalRecord/$numPerPage)-1>$currPage){
	            $after_link = "<a style='text-decoration:none; color:#fff; margin-top:125px;' href=./". $url;
	            if($currPage>0 && $currPage==($currBlock+1)*$page_per_block)
	                $currBlock++;
	                    $after_link = $after_link . "?currBlock=" . $currBlock;
	                if($currPage<(int)($totalRecord/$numPerPage)){
	                    $after_link = $after_link . "&currPage=" . ($currPage+1);
	                } else {
	                    $after_link = $after_link . "&currPage=" . $currPage;
	                }
	                //$after_link = $after_link . ">&nbsp;&nbsp;<img src='/tenasia/resources/img/notice/btn_next.png' style='margin-bottom:-4px; width:23px height:23px;'>";
	                $after_link = $after_link . ">Следующая... >";
	        }

	        if((int)($totalRecord/$numPerPage)-1>=$currPage){
	            $after_link = $after_link . "</a>";
	        }

	        if($currBlock > 0){
	            $pre_link = "<a style='text-decoration:none; color:#fff;' href=./".$url;
	                $pre_link = $pre_link . "?currBlock=" . ($currBlock-1);
	                $pre_link .= "&currPage=" . (($currBlock-1)*$page_per_block);
	                //$pre_link .= "><img src='/tenasia/resources/img/notice/btn_prev_block.png' style='margin-bottom:-4px; width:23px height:23px;'>&nbsp;&nbsp</a>";
	                $pre_link .= ">pre_link</a>";
	        }

	        for ($i = 0; $i < $page_per_block; $i++) {

	        	if($currPage != ($currBlock*$page_per_block) + $i){
	        		$curr_link=$curr_link . "<a style='text-decoration:none; font-size:15px; color:#fff;' href=./".$url;
	                $curr_link=$curr_link . "?currBlock=" . $currBlock;
	            	$curr_link=$curr_link . "&currPage=" . (($currBlock*$page_per_block) + $i);
	            	$curr_link=$curr_link . ">";
	        	}else{
	        		$curr_link=$curr_link . "<a style='text-decoration:none; font-size:15px; color:#fff; pointer-events: none; cursor: default; background-color:#80008099;;' href=./".$url;
	                $curr_link=$curr_link . "?currBlock=" . $currBlock;
		            $curr_link=$curr_link . "&currPage=" . (($currBlock*$page_per_block) + $i);
		            $curr_link=$curr_link . ">";
	        	}

	            if($currPage == ($currBlock*$page_per_block) + $i){
	                $curr_link = $curr_link . "<font color=#fff><b>";
	                $curr_link=$curr_link . (($currBlock * $page_per_block) + $i + 1)."</b></font></a>";
	            }else{
	                $curr_link=$curr_link . (($currBlock * $page_per_block) + $i + 1)."</a> ";
	            }

	            if(($i+1)%$page_per_block!=0 && ($currBlock * $page_per_block) + $i + 1!=$total_page){
	                $curr_link.="";
	            }

	            if (($currBlock * $page_per_block) + $i + 1 == $total_page)  break;
	        }

	        if ($total_block > $currBlock + 1) {
	            $next_link = "<a style='text-decoration:none; color:#fff;' href=./".$url;
	                $next_link = $next_link ."?currBlock=".($currBlock + 1);
	                $next_link .= "&currPage=".(($currBlock + 1) * $page_per_block);
	            	//$next_link .= $next_link . ""
	                //$next_link .= ">&nbsp;&nbsp;<img src='/tenasia/resources/img/notice/btn_next_block.png' style='margin-bottom:-4px; width:23px height:23px;'></a>";
	                $next_link .= ">next_link</a>";
	        }
	    }
	    $link_str=$pre_link.$before_link.$curr_link.$after_link.$next_link;

	    return $link_str;
	}

	// 위대한 추가

	function getplaintextintrofromhtml($html, $numchars) {
	    // Remove the HTML tags
	    $stripedStr = strip_tags($html);
	    // Convert HTML entities to single characters
	    $decodedStr = html_entity_decode($stripedStr, ENT_QUOTES, 'UTF-8');
	    // Make the string the desired number of characters
	    // Note that substr is not good as it counts by bytes and not characters
	    if(strlen($decodedStr) > $numchars){
	    	$subStr = mb_substr($decodedStr, 0, $numchars, 'UTF-8');
	    	// Add an elipsis
	    	$decodedStr = $subStr . "…";
		}
	    return $decodedStr;
	}

	function replaceNbsp($intro){
		$str = htmlentities($intro, null, 'utf-8');
		$replaced = str_replace("&nbsp;", "<br>", $str);
		return $replaced;
	}

?>
