<?php
require('../_app/Config.inc.php');

$cats = new Read;
$cats->ExeRead("gallery_categories");

echo json_encode($cats->getResult(), JSON_FORCE_OBJECT);

?>