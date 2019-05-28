<?php

require 'dbConnect.php';

$query = 'SELECT recordTime, productSum FROM RECORD WHERE USERID='.$_COOKIE['userID'].' ORDER BY RECORDTIME';
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

$string = "<table class=\"table\">";
$string .= "<thead><tr><th>Time</th><th>Total Price</th><th>Record</th></tr></thead>";
$string .= "<tbody>";

while ($datas = $result->fetch_object()) {
    $string .= "<tr><td>$datas->recordTime</td><td>HKD$datas->productSum</td><td><a href = \"recordPDF.php?recordTime=$datas->recordTime\"><span class = \"glyphicon glyphicon-folder-open\"></span></a></td></tr>";
}

$string .= "</tbody>";
$string .= "</table>";

echo $string;

$mysqli->close();
