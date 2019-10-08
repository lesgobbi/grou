<?php

$data = $_POST['file'];

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$ext = $type == 'data:image/jpeg' ? '.jpg' : '.png';

$data = base64_decode($data);

file_put_contents('../../../uploads/' . md5(time()) . $ext, $data);

echo md5(time()) . $ext;

