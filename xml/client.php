<?php
error_reporting(E_ALL);
ini_set('dispalay_error',1);
session_start();

//panggil library
require_once('nusoap/lib/nusoap.php');
//men
$url = 'http://localhost/ws.git/xml/server.php?wsdl';

$client = new nusoap_client($url, 'WSDL');

$username = isset($_POST["username"]) ? $_POST["username"] : 'admin';
$password = isset($_POST["password"]) ? $_POST["password"] : 'admin';
$result = $client->call('login_ws',array('username'=>$username, 'password'=>$password));

if($result == "Login Berhasil"){
	$_SESSION['username']= $username;
} else{
		header ("location: login.php");
}
?>