
<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";

$pdo=getDBConnection();
$sql="SELECT * FROM answers where is_correct = 1";
if ($stmt=$pdo->prepare($sql)) {
        if ($stmt->execute()) {
        $rows=$stmt->fetchAll();
    }
}
$numberCorrect=0;
$output=array();
$count=1;
foreach ($_POST as $qid=>$user_answer) {
    foreach ($rows as $row){
        if ($qid==$row['question_id']) {
            if ($user_answer==$row['text']){
                $numberCorrect++;
                $output[]="Number $count was correct.";
            }else{
                $output[]="Number $count was not correct. The correct answer was " .$row['text'];
            }
        }

    }
    $count++;
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
    <?php
    foreach ($output as $question) {

   ?>
        <h2><?=$question?></h2>

        <?php
    }
    ?>
 <h1><?=$numberCorrect?> out of 10</h1>
    <h1>Grade: <?=$numberCorrect/10*100?></h1>
    <p><a href="chooseQuiz.php">Return to Topics Page</a></p>
    </body>
    </html>

