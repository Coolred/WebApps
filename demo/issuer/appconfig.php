<?php
setcookie('customappkey', $_POST['appkey'], time() + (365 * 24 * 60 * 60), '/');
setcookie('customappsecret', $_POST['appsecret'], time() + (365 * 24 * 60 * 60), '/');
setcookie('custombrand', $_POST['cardbrand'], time() + (365 * 24 * 60 * 60), '/');

$newURL = 'apply.php';
header('Location: '.$newURL);
?>
