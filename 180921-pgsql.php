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
$db_p = parse_url( getenv("DATABASE_URL") );
$db_p["path"]=ltrim($db_p["path"],"/");
print_r( $db_p );
$db_url="pgsql:host=".$db_p['host'].";port=".$db_p['port'].";user=".$db_p['user'].";password=".$db_p['pass'].";dbname=".$db_p["path"].";";
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



try{
$table_name = "nya180923";
echo '[pgsql]table_name='.$table_name;
echo "\n";
//移除table
if(0){
$sql=<<<EOT
DROP TABLE IF EXISTS $table_name
EOT;
//IF NOT EXISTS
//$stmt = $db->prepare($sql);
//$stmt->execute();
$stmt=$db->query($sql);
//echo 'del table';
}
  
//建立table
$sql=<<<EOT
CREATE TABLE IF NOT EXISTS $table_name
(
    c01 UNIQUE text NOT NULL,
    c02 text NOT NULL,
    c03 text NOT NULL,
    ID SERIAL PRIMARY KEY,
    timestamp timestamp default current_timestamp,
)
EOT;
//IF NOT EXISTS
$stmt=$db->query($sql);
//$stmt = $db->prepare($sql);
//$stmt->execute();

  
//列出全部table
$sql=<<<EOT
SELECT * FROM pg_catalog.pg_tables 
WHERE schemaname != 'pg_catalog' 
AND schemaname != 'information_schema';
EOT;
//AND schemaname != 'information_schema';
$stmt=$db->query($sql);
//$stmt = $db->prepare($sql);
//$stmt->execute();
  
$cc=0;
while ($row = $stmt->fetch() ) {
  $cc++;
  echo $cc."\t";
  echo $row['tablename']."\t";
  echo "\n";
}

  
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息



try{
//
$sql=<<<EOT
SELECT pg_size_pretty(pg_database_size('Database Name'));
EOT;
$sql=<<<EOT
SELECT pg_size_pretty(pg_relation_size('{$table_name}'));
EOT;
$sql=<<<EOT
SELECT pg_size_pretty( pg_total_relation_size('{$table_name}') );
EOT;
  
echo $sql;
echo "\n";

foreach( $db->query($sql) as $k => $v ){
  echo '[pgsql]total_relation_size='.$v[0]."\n";
}
//
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息




?>
