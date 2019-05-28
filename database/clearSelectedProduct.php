<?php

require 'dbConnect.php';

$query = "DELETE FROM SELECTEDPRODUCT WHERE USERID=".$_COOKIE['userID'];
$mysqli->query($query);

$mysqli->close();

