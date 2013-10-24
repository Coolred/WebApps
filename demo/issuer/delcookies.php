<?php

setcookie('customappkey', "", time()-3600, '/');
setcookie('customappsecret', "", time()-3600, '/');

$newURL = 'apply.php';
header('Location: '.$newURL);
?>