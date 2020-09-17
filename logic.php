<?php
//phpinfo();
function Judg($num)
{

    //substr string and comparison after output A or B
    $result = "";
    $length = 1;
    $answer = $_SESSION['answer'];
    $offsetArr = [];
    $A = 0; //數字與位置正確
    $B = 0; //數字正確位置錯誤
    $numArr = str_split($num);
    $numArr = array_unique($numArr);
    //計算重複數字,預先扣除$B的數量
    foreach ($numArr as $key => $value) {
        $doubleNumCount = substr_count($num, $value) - substr_count($answer, $value);
        if (substr_count($answer, $value) >= 1 && $doubleNumCount > 0) {
            $B -= $doubleNumCount;
        }
    }

    for ($i = 0; $i < strlen($num); $i++) {
        //$x = substr($num, $i, $length);
        $y = substr($answer, $i, $length);
        for ($j = 0; $j < strlen($num); $j++) {
            $x = substr($num, $j, $length);
            //計算A並且清除字串避免重複計算
            ($i == $j && $x == $y) ? ($A++) . ($y = "-") . ($answer = substr_replace($answer, "-", $i, 1)) . ($num = substr_replace($num, " ", $j, 1)) : '';
            //計算B並且清除字串避免重複計算
            ($i != $j && $x == $y) ? ($B++) . ($num = substr_replace($num, " ", $j, 1)) : '';
        }
    }
    ($B < 0) ? $B = 0 : '';
    $result = $A . "A" . $B . "B";
    //A<4 表示不完全正確 
    if ($A < 4) {
        return ($result != "") ? $result : "-1";
    } else {
        return "SUSSECC !!  Answer = " . $_SESSION['answer'];
    }
}
function checkNumFormat($num, $count)
{
    if(!isset($_SESSION['answer'])){
        return "Please click the START";
    }
    //is number ?
    if (!is_numeric($num)) {
        return "Please enter the number";
    }
    // number length
    if (strlen($num) > $count) {
        return "Number length too long";
    } else if (strlen($num) < $count) {
        return "Number length too short";
    }
    return true;
}

session_start();
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$userNum = $_POST["userNum"];
    if (isset($userNum)) {
        $result = null;
        //確認是否為4碼數字並且符合答案長度
        $isNum = checkNumFormat($userNum, 4);
        //若符合規定就執行幾A幾B判斷
        if ($isNum === true) {
            $result = Judg($userNum);
        } else {
            $result = $isNum;
        }
        echo json_encode(array(
            'msg' => $userNum . " OK",
            'result' => $result,
            'answer' => $_SESSION['answer'],
        ));
    } else {
        echo json_encode(array(
            'msg' => "ERROR",
        ));
    }

}
