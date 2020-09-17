<?php
session_start();

function SetAnswer($count)
{
    $answer = "";
    for ($i=0; $i < $count; $i++) { 
        $answer .= rand(0,9);
    }
    $_SESSION['answer'] = $answer;
}
$_SESSION['answer'] ="";
SetAnswer(4);
return;
