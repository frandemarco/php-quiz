<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$pdo=getDBConnection();
$sql="SELECT * FROM quizzes";
if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
        $rows=$stmt->fetchAll();
    }else{
        
    }
}else{
    
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="quiz.php">
    <?php
    foreach($rows as $row){
    ?>
        <label> <?=$row["topic"]?><input type="radio" name="quiz" value="<?=$row["id"]?>"> </label>
    <?php
    }
    ?>
    <input type="submit" value="Start Quiz">
</form>
</body>
</html>
