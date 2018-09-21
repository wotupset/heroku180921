<?php
//header("content-Type: application/json; charset=utf-8"); //強制
date_default_timezone_set("Asia/Taipei");//時區設定
//date_default_timezone_set("UTC");//時區設定
$tz=date_default_timezone_get();
//echo 'php_timezone='.$tz."\n";
$time  =time();
$time2 =array_sum( explode( ' ' , microtime() ) );
$php_info=pathinfo($_SERVER["PHP_SELF"]);//被執行的文件檔名
//$php_dir=$php_info['dirname'];//
$phpself=$php_info['basename'];
//extract($_POST,EXTR_SKIP);extract($_GET,EXTR_SKIP);extract($_COOKIE,EXTR_SKIP);
$query_string=$_SERVER['QUERY_STRING'];
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

try{
//連結

$pdb = new PDO(getenv("DATABASE_URL") );
	



}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤(連結):".$chk);}//錯誤訊息



?>
