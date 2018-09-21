<?php
//header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示


try{
$db = parse_url( getenv("DATABASE_URL") );
$db["path"]=ltrim($db["path"],"/");
print_r( $db );
$db_url="pgsql:host=".$db['host'].";port=".$db['port'].";user=".$db['user'].";password=".$db['pass'].";dbname=".$db["path"].";";
print_r($db_url );
                           
//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
  
  
$pdo = new PDO( $db_url );


               
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息


?>
