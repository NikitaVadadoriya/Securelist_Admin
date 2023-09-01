<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once($_SERVER['DOCUMENT_ROOT'] . '/greenenergy/public/API/pass/PasswordHash.php');
$t_hasher = new PasswordHash(8, true);
$uhash = $t_hasher->HashPassword("jay@123#");
echo $uhash;

// $options = ['cost' => 12,];
// $password_hash = password_hash("Admin@123#", PASSWORD_BCRYPT, $options);
// echo $password_hash;
