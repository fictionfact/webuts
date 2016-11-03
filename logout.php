<?php 
	setcookie("logged_in", null, time()-1);
	header("Location: main.php")
 ?>