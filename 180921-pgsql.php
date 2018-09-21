<?php
header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示


try{
$db = parse_url( getenv("DATABASE_URL") );
$db["path"]=ltrim($db["path"],"/");
print_r( $db );
$db_url="pgsql:host=".$db['host'].";port=".$db['port'].";user=".$db['user'].";password=".$db['pass'].";dbname=".$db["path"].";";
print_r($db_url );
                           
//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
  
  
$pdo = new PDO( $db_url );

if(!$pdo){
  die('連線失敗');
}else{
  echo '連線狀態='.$db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
  echo "\n";
}
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息


echo 'version_php='.phpversion()."\n";
foreach( $db->query("select version();") as $k => $v ){
  echo 'version_pgsql='.$v[0]."\n";
}


?>
