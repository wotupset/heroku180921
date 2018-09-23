<?php
header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示


$time  =time();
$time2 =array_sum( explode( ' ' , microtime() ) );
date_default_timezone_set("Asia/Taipei");//時區設定
//date_default_timezone_set("UTC");//時區設定
$timezone=date_default_timezone_get();
echo '[php]timezone='.$timezone."\n";
echo '[php]now='.date("Y-m-d H:i:s",$time)."\n";
echo '[php]UTC='.gmdate("Y-m-d H:i:s",$time)."\n";


///
try{
$db = parse_url( getenv("DATABASE_URL") );
$db["path"]=ltrim($db["path"],"/");
print_r( $db );
$db_url="pgsql:host=".$db['host'].";port=".$db['port'].";user=".$db['user'].";password=".$db['pass'].";dbname=".$db["path"].";";
print_r($db_url );
                           
//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
  
  
$db = new PDO( $db_url );
echo "\n";
if(!$db){die('連線失敗');}
echo '連線狀態='.$db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
echo "\n";

}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息


///



echo '[php]version='.phpversion()."\n";
foreach( $db->query("select version();") as $k => $v ){
  echo '[pgsql]version='.$v[0]."\n";
}



foreach( $db->query("SELECT now()::date, now()::time") as $k => $v ){
  print_r($v);
  echo '[pgsql]now()='.$v[0]." ".$v[1]."\n";
}

$stmt=$db->query("SELECT CURRENT_DATE,CURRENT_TIME,CURRENT_TIMESTAMP,LOCALTIMESTAMP");
//print_r($stmt);
//while ($row = $stmt->fetch() ){}
$row = $stmt->fetch();//取回第一筆資料
print_r($row);
echo '[pgsql]current_timestamp='.$row['current_timestamp'];
echo "\n";
echo '[pgsql]localtimestamp='.$row['localtimestamp'];
echo "\n";

?>
