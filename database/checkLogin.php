<?php

// When no cookie
// Time limit = 10 minutes
if (!isset($_COOKIE['login'])) {
    setcookie('login', "0", time() + 60 * 30, "/") or die('unable to create cookie');
    setcookie('loginTime', "-1", time() + 60 * 30, "/") or die('unable to create cookie');
    setcookie('userID', "-1", time() + 60 * 30, "/") or die('unable to create cookie');
    setcookie('username', "-1", time() + 60 * 30, "/") or die('unable to create cookie');
}