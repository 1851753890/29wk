<?php
function processCx($oid) {
	global $DB;
	$d = $DB -> get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB -> get_row("select hid,user,pass from qingka_wangke_order where oid='{$oid}' ");
	$a = $DB -> get_row("select * from qingka_wangke_huoyuan where hid='{$b["hid"]}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$user = $b["user"];
	$pass = $b["pass"];
	$kcname = $d["kcname"];
	$school = $d["school"];
	$pt = $d["noun"];
	$kcid = $d["kcid"];
	//大雄学习平台进度
	if ($type == "Mylover") {
		$data = array("username" => $user);
		$dx_rl = $a["url"];
		$dx_url = "$dx_rl/api.php?act=chadan";
		$result = get_url($dx_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "1") {
			foreach($result["data"] as $res) {
				$yid = $res["id"];
				$kcname = $res["kcname"];
				$status = $res["status"];
				$process = $res["process"];
				$remarks = $res["remarks"];
				$kcks = $res["courseStartTime"];
				$kcjs = $res["courseEndTime"];
				$ksks = $res["examStartTime"];
				$ksjs = $res["examEndTime"];
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user,
					"pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
			}
		} else {
			$b[] = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;
	}
	
	else if ($type == "yhh") {
		$data = array(
		    "account" => $user,
		    "password" => $pass,
		    "name" => $kcname
		);
		$eq_rl = $a["url"];
		$eq_url = "$eq_rl/Api/index/QueryOrder?ApiToken=$token";
		$result = get_url($eq_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "1") {
			foreach($result["data"] as $res) {
				$kcname = $res["kcname"];
				$status = $res["status_text"];
				$process = $res["complete"];
				$remarks = $res["exam_score"];
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass,"status_text" => $status_text,"process" => $progress,"remarks"=>$remarks);   
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;
	}
} 
?>