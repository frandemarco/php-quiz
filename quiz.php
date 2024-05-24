<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
$pdo=getDBConnection();
$chosenQuiz=$_GET["quiz"];
$sql="SELECT * from questions 
         where quiz_id=:quizid
         order by rand() limit 10";
if ($stmt=$pdo->prepare($sql)) {
    $stmt->bindParam(":quizid",$chosenQuiz);
    if ($stmt->execute()) {
        $rows=$stmt->fetchAll();
    }
}
$sql2= "Select topic from quizzes where id = :quizid";
if ($stmt2=$pdo->prepare($sql2)) {
    $stmt2->bindParam(":quizid",$chosenQuiz);
    if ($stmt2->execute()) {
        $quizName=$stmt2->fetch();
    }
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
<h1>Welcome to the <?=$quizName["topic"]?> quiz</h1>
<form action="results.php" method="post">
    <ol>
    <?php
    foreach ($rows as $row) {
        $question=$row["question_text"];
        $quesId=$row["id"];
    ?>
        <li><?= $question ?></li>
        <ul>
    <?php
        $answerSql="select * from answers where question_id=:question_id
order by rand()";
        if ($answerStmt=$pdo->prepare($answerSql)) {
            $answerStmt->bindParam(":question_id",$quesId);
            if ($answerStmt->execute()) {
                $answers=$answerStmt->fetchAll();
                foreach ($answers as $answer) {
                    ?>
                    <li><input type="radio" name="<?=$quesId?>" value="<?= $answer["text"]?>"><?= $answer["text"]?></li>
                    <?php
                }
            }
        }
        unset($answerStmt);
        unset($answerSql);
        unset($answers);
        unset($answer);
        ?>
        </ul>
    <?php
    }
    ?>

    </ol>
    <input type="submit" Value="Get Grade">
</form>
</body>
</html>
