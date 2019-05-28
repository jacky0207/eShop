<?php

require 'dbConnect.php';

$query = "DELETE FROM SELECTEDPRODUCT WHERE USERID=".$_COOKIE['userID']." AND PRODUCTID=".$option;
$mysqli->query($query);

$mysqli->close();

