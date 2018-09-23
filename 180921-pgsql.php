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
$table_name=<<<EOT
nya170415
EOT;
echo '[pgsql]table_name='.$table_name;
echo "\n";
//移除table
if(1){
$sql=<<<EOT
DROP TABLE IF EXISTS {$table_name}
EOT;
print_r($sql);
echo "\n";
//IF NOT EXISTS
//$stmt = $db->prepare($sql);
//$stmt->execute();
$stmt=$db->query($sql);
$err=$db->errorInfo();
if($err[0]>0){print_r( $err );}
//echo 'del table';
}
  
//建立table
$sql=<<<EOT
CREATE TABLE IF NOT EXISTS {$table_name} 
(
    c01 text UNIQUE NOT NULL,
    c02 text NOT NULL,
    c03 text NOT NULL,
    ID SERIAL PRIMARY KEY,
    timestamp timestamp default current_timestamp
)
EOT;
print_r($sql);
echo "\n";
//IF NOT EXISTS
$stmt=$db->query($sql);
//$stmt = $db->prepare($sql);
//$stmt->execute();
$err=$db->errorInfo();
if($err[0]>0){print_r( $err );}

  
//列出全部table
$sql=<<<EOT
SELECT * FROM pg_catalog.pg_tables 
WHERE schemaname != 'pg_catalog' 
AND schemaname != 'information_schema';
EOT;
$sql=<<<EOT
SELECT * FROM pg_catalog.pg_tables 
WHERE schemaname = 'public';
EOT;
/*
information_schema.tables 
  table_schema = 'public'

*/
  
print_r($sql);
echo "\n";
//AND schemaname != 'information_schema';
$stmt=$db->query($sql);
//$stmt = $db->prepare($sql);
//$stmt->execute();
$err=$db->errorInfo();
if($err[0]>0){print_r( $err );}

/*
    [schemaname] => public
    [0] => public
    [tablename] => nya170415
    [1] => nya170415
    [tableowner] => oircengeeaxksk
    [2] => oircengeeaxksk
    [tablespace] => 
    [3] => 
    [hasindexes] => 1
    [4] => 1
    [hasrules] => 
    [5] => 
    [hastriggers] => 
    [6] => 
    [rowsecurity] => 
    [7] => 
*/
$cc=0;
while ($row = $stmt->fetch() ) {
  //print_r($row);
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
SELECT pg_size_pretty( pg_total_relation_size( '{$table_name}' ) );
EOT;
$sql=<<<EOT
SELECT pg_size_pretty(pg_database_size(current_database()));
EOT;
$sql=<<<EOT
SELECT pg_size_pretty( pg_total_relation_size( public ) );
EOT;

/*

*/
print_r($sql);
echo "\n";
$stmt=$db->query($sql);
$err=$db->errorInfo();

if($err[0]>0){print_r( $err );}

print_r($stmt);

$cc=0;
while($row = $stmt->fetch() ) {
  print_r($cc++);
  print_r($row);
}


//
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息




?>
