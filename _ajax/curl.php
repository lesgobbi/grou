<?php

$ch = curl_init($_GET['url']);
curl_exec($ch);
echo $ch;
curl_close($ch);

?>