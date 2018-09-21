<?php
//header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示


try{
$dbopts = parse_url(getenv("DATABASE_URL"));
print_r($dbopts );

$db_url=sprintf("pgsql:host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $dbopts["host"],
    $dbopts["port"],
    $dbopts["user"],
    $dbopts["pass"],
    ltrim(dbopts["path"], "/");
print_r($db_url );
                           
//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
//$pdo = new PDO();


               
}catch(PDOException $e){$chk=$e->getMessage();print_r("try-catch錯誤:".$chk);}//錯誤訊息


?>
