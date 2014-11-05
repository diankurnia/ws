<?php
session_start();
session_destroy();
unset($_SESSION['username']);
?>
<center>
<h2>Anda telah berhasil logout..</h2>
Silahkan klik <a href="login.php"><b>disini</b></a> untuk login kembali
</center>