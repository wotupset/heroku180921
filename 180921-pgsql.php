<?php
//header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

$dbopts = parse_url(getenv("DATABASE_URL"));
print_r($$dbopts );

//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
$pdo = new PDO(sprintf("pgsql:host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $dbopts["host"],
    $dbopts["port"],
    $dbopts["user"],
    $dbopts["pass"],
    ltrim(dbopts["path"], "/")
));


?>
