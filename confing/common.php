<?php
error_reporting(0);
define('IN_CRONLITE', true);
define('ROOT', dirname(__FILE__).'/');//返回当前文件路径的 路径部分,就是取当前目录
define('SYS_KEY', "qingka");

$date = date("Y-m-d H:i:s");
$jtdate=date("Y-m-d");
$ztdate=date("Y-m-d",strtotime("-1 day"));
$qtdate=date("Y-m-d",strtotime("-2 day"));
$wqtdate=date("Y-m-d",strtotime("-3 day"));
$wwqtdate=date("Y-m-d",strtotime("-4 day"));
$wwwqtdate=date("Y-m-d",strtotime("-5 day"));
$wwwwqtdate=date("Y-m-d",strtotime("-6 day"));
//连接数据库
session_start();
include_once(ROOT."config.php");
$DB=new DB($host,$user,$pwd,$dbname,$port);
include ROOT."epay/epay.config.php"; 
$sql1=$DB->query("SELECT * FROM `qingka_wangke_config`");
while($row=$DB->fetch($sql1)){
	$conf[$row['v']]=$row['k'];
}
$password_hash='!@#%!s?';
include ROOT."../Checkorder/configuration.php";
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = 'http';
$alipay_config['apiurl']        = $conf['epay_api'];
$alipay_config['partner']		= $conf['epay_pid'];
$alipay_config['key']			= $conf['epay_key'];
if(!defined('IN_CRONLITE'))exit();
$clientip=real_ip();
if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$udata = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE user='$user' limit 1");
	$session=md5($udata['user'].$udata['pass'].$password_hash);
	if($session==$sid) {
		$DB->query("UPDATE qingka_wangke_user SET endtime='$date',ip='$clientip' WHERE user = '$user' ");
		$islogin=1;
		$userrow = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE user='$user' limit 1");
		if($udata['active']==0){
			@header('Content-Type: text/html; charset=UTF-8');
			exit('您的账号已被封禁！');
		}
	}
}
?>