<?php
//call library
	require_once('nusoap/lib/nusoap.php');
	require_once('adodb/adodb/adodb.inc.php');
	$server = new nusoap_server;
	$server->configureWSDL('server','urn:server');
	$server->wsdl->schemaTargetNamespace = 'urn:server';
	
//register a function that works on server
	$server->register('login_ws',array('username'=>'xsd:string','password'=>'xsd:string'), //parameters
	array('return'=>'xsd:string'), //output
	'urn:server', //namespace
	'urn:server#LoginServer', //soapaction
	'rpc', //style
	'encoded', //use
	'Login'); //description
	
//create function
function login_ws($username, $password){
	//enkripsi password dengan md5
	$password = md5($password);
	//buat koneksi
	$db = NewADOConnection('mysql');
	$db -> Connect('localhost','root','','data_mahasiswa');
	//cek username dan password dari database
	$sql = $db -> execute("SELECT * FROM user where username='$username' AND password='$password'");
	//cek adanya username dan password di database
	if($sql->RecordCount() >= 1)//sama dengan msql_num_rows pada php biasa
	{
		return "Login Berhasil";
	}else{
		return "Login Gagal";
	}
}

//create HTTP listener
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA: '';
$server->service($HTTP_RAW_POST_DATA);
?>