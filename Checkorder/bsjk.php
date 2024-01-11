<?php  
function budanWk($oid) {
	global $DB;
	global $wk;
	$d = $DB -> get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB -> get_row("select hid,yid,user from qingka_wangke_order where oid='{$oid}' ");
	$hid = $b["hid"];
	$yid = $b["yid"];
	$user = $b["user"];
	$a = $DB -> get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];

	//27补刷
	if ($type == "plus") {
       $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
       $dx_rl = $a["url"];
       $dx_url = "$dx_rl/api.php?act=budan";
       $result = get_url($dx_url, $data);
       $result = json_decode($result, true);
       return $result;
    }
	//大雄学习平台补刷 放在/Checkorder/bsjk.php 文件
	else if ($type == "Mylover") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
		$dx_rl = $a["url"];
		$dx_url = "$dx_rl/api.php?act=budan";
		$result = get_url($dx_url, $data);
		$result = json_decode($result, true);
		return $result;
	}
	//yhh
	else if ($type == "yhh") {
		$data = array(
		    "account" => $user,
		    "password" => $pass,
		    "name" => $kcname,
		);
		$url = $a["url"];
		$yhh_url = "$url/Api/index/RetryOrder?ApiToken=$token";
		$result = get_url($yhh_url, $data);
		$result = json_decode($result, true);
		if ($result['code'] == 1) {
		    $b[] = array("code" => 1, "msg" => "操作成功!");
		}else{
		    $b[] = array("code" => -1, "msg" => $result['msg']);
		}
		return $b;
	} 
	else {
		$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
	}
}
?>