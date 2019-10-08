<?php
require('../_app/Config.inc.php');

$Gallery = new Read;
$Gallery->ExeRead("posts_gallery", "WHERE post_id = :post ORDER BY gallery_order ASC", "post=1");

echo json_encode($Gallery->getResult(), JSON_FORCE_OBJECT);

?>