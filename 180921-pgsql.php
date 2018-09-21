<?php
//header("content-Type: application/json; charset=utf-8"); //強制

error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

$pdb = new PDO(getenv("DATABASE_URL") );



?>
