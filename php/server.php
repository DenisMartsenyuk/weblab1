<?php
$xValue = $_GET["x"];
$yValue = $_GET["y"];
$rValue = $_GET["r"];

session_start();

date_default_timezone_set('Europe/Moscow');
$currentTime = date("H:i:s");
$startTime = microtime(true);

if (validation($xValue, $yValue, $rValue)) {
    if (checkHitRegion($xValue, $yValue, $rValue)) {
        $result = "Попал";
    } else {
        $result = "Не попал";
    }
    $timeExecute = number_format(microtime(true) - $startTime, 10);

    $resultRow = "
    <tr>
        <td>$xValue</td>
        <td>$yValue</td>
        <td>$rValue</td>
        <td>$result</td>
        <td>$currentTime</td>
        <td>$timeExecute</td>
    </tr>";

    if (!isset($_SESSION['history'])) {
        $_SESSION['history'] = "";
    }
    $_SESSION['history'] .= $resultRow;

    echo $_SESSION['history'];

} else {
    http_response_code(400);
}

function validation($xValue, $yValue, $rValue) {
    if (!checkNumber($xValue) || !checkNumber($yValue) || !checkNumber($rValue)) {
        return false;
    }

    if (!checkX($xValue) || !checkY($yValue) || !checkR($rValue)) {
        return false;
    }
    return true;
}

function checkNumber($value) {
    if (!is_numeric($value)) {
        return false;
    }
    return true;
}

function checkX($x) {
    if (in_array($x, array(-4, -3, -2, -1, 0, 1, 2, 3, 4))) {
        return true;
    }
    return false;
}

function checkY($y) {
    if ($y < -3 || $y >3) {
        return false;
    }
    return true;
}

function checkR($r) {
    if (in_array($r, array(1, 2, 3, 4, 5))) {
        return true;
    }
    return false;
}

function checkHitRegion($x, $y, $r) {
    if ($x >= 0 && $y >= 0 && $x <= $r  && $y <= $r ||
        $x >= 0 && $y < 0 && ($x * $x + $y * $y <= $r * $r) ||
        $x < 0 && $y >= 0 && $r + $x >= 2 * $y) {
        return true;
    }
    return false;
}