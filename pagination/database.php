<?php
	$mysqlHost     = 'localhost';
	$mysqlUser     = 'uder';
	$mysqlPass     = 'password';
	$mysqlDatabase = 'database';

$mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDatabase);
if ($mysqli->connect_errno) {
    die("Connect failed: " . $mysqli->connect_error);
}
?>
