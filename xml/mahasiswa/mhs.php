<?php
// header untuk format xml jika dihilangkan akan berbentuk  data string
header('Content-Type: text/xml; charset=ISO-8859-1');
include "koneksi.php";

//check for the path elements
$path_params = array();
$self = $_SERVER['PHP_SELF'];
$extension = substr($self, strlen($self)-3);
$path = ($extension=='php') ? NULL : $_SERVER['PATH_INFO'];


if($path != null){
	$path_params = spliti("/",$path);
}
// metode request untuk get
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isset($path_params[1]) && $path_params[1] != null){
		$query = "SELECT nim,nama,alamat,prodi FROM mahasiswa WHERE nim = nim = '%s'";
		 $query = sprintf($query, mysql_real_escape_string($path_params[1]));
	} else{
		$query = "SELECT nim,nama,alamat,prodi FROM mahasiswa";
	}
	$result = mysql_query($query) or die('Query failed: '.mysql_error());
	echo "<data>";
	while($line = mysql_fetch_array($result, MYSQL_ASSOC)){
		echo "<mahasiswa>";
		foreach($line as $key => $col_value){
			echo "<$key>$col_value</$key>";
		}
		echo "</mahasiswa>";
	}
	echo "</data>";
	mysql_free_result($result);
}
// method untuk post
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $querycek = "SELECT * FROM mahasiswa WHERE nim='%s'";
  $querycek = sprintf($querycek, mysql_real_escape_string($_POST['nim']));
  $querycek = mysql_query($querycek);
  $num_rows = mysql_num_rows($querycek);
  if ($num_rows == 0){
	$query = "INSERT INTO mahasiswa (nim, nama, alamat, prodi) VALUES ( '%s','%s','%s','%s' )";
    $query = sprintf($query, $_POST['nim'], $_POST['nama'], $_POST['alamat'], $_POST['prodi'] );
  }else if ($num_rows == 1){
    $query = "UPDATE mahasiswa SET nim = '%s', nama = '%s', alamat = '%s' , prodi= '%s' WHERE nim = '%s'";
    $query = sprintf($query, $_POST['nim'], $_POST['nama'], $_POST['alamat'], $_POST['prodi'], $_POST['nim'] );
  }
  $result = mysql_query($query) or die ('Query Failed : '. mysql_error());
}
mysql_close($link);
?>