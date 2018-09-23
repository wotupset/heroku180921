<?php
header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

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
//echo '1連線狀態='.$db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
echo "\n";

}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息


///



echo 'version_php='.phpversion()."\n";
foreach( $db->query("select version();") as $k => $v ){
  echo 'version_pgsql='.$v[0]."\n";
}



foreach( $db->query("SELECT now()::date, now()::time") as $k => $v ){
  print_r($v);
  echo 'pgsql_time='.$v[0]." ".$v[1]."\n";
}

$stmt=$db->query("SELECT CURRENT_DATE,CURRENT_TIME,CURRENT_TIMESTAMP,LOCALTIMESTAMP");
//print_r($stmt);
//while ($row = $stmt->fetch() ){}
$row = $stmt->fetch();//取回第一筆資料
print_r($row);
echo 'pgsql_timestamp='.$row['timestamp'];
echo "\n";

?>
