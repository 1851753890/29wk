<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在跳转支付界面...</title>
</head>
<?php
include("../confing/common.php");
require_once("epay/submit.class.php");
$type = $_POST['type'];  //支付方式
$out_trade_no=$_POST['out_trade_no'];//支付单号
$row=$DB->get_row("select * from qingka_wangke_pay where `out_trade_no`='{$out_trade_no}' limit 1 ");
$DB->query("update `qingka_wangke_pay` set `type`='$type' where `out_trade_no`='{$out_trade_no}'");

//构造请求的参数数组
$parameter = array(
	"pid" => trim($alipay_config['partner']),
	"type" => $type,
	"notify_url"	=> 'http://'.$row['domain'].'/epay/notify_url.php',
	"return_url"	=> 'http://'.$row['domain'].'/epay/return_url.php',
	"out_trade_no"	=> $row['out_trade_no'],
	"name"	=> $row['name'],
	"money"	=> $row['money'],
	"sitename"	=> $row['domain']
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter);
echo $html_text;
?>
</body>
</html>