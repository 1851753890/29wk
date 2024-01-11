<?php  

function wkname()
{
	$data = array(
	    "Mylover" => "Mylover",
	    "welearn_all" => "welearn_all",
	    "welearn_unit" => "welearn_unit",
	    "xxt"=>"xxt"
	    );
	return $data;
}

function addWk($oid) {
	global $DB;
	global $wk;
	$d = $DB -> get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];
	$b = $DB -> get_row("select * from qingka_wangke_class where cid='{$cid}' ");
	$hid = $b["docking"];
	$a = $DB -> get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];

	//大雄学习平台下单接口 放在/Checkorder/xdjk.php 文件
	if ($type == "Mylover") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" =>
			$user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
		$dx_rl = $a["url"];
		$dx_url = "$dx_rl/api.php?act=add";
		$result = get_url($dx_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
			$b = array("code" => 1, "msg" => "下单成功");
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;
	}
}
?>