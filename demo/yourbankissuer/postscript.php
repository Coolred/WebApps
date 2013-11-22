<?php
session_start();

	if(isset($_POST['script'])){
		$filename = $_SESSION['token'] . '.txt';
		$fh = fopen($filename,'w'); 
		$writeData = $_POST['script']; 
		fwrite($fh, $writeData); 
		$_SESSION['filename'] = $filename;
		fclose($fh);
	 }
	 else{
	 	die('no post data');
	 }

	header('Location: stissuer.php');