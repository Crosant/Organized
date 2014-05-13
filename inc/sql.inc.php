<?php
// PDO
    try{
		$pdo = new PDO('mysql:host=localhost;dbname=planer', 'test', 'test');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo $e->getMessage();
		die();
    }
?>