<?php
$table = filter_input(INPUT_POST, 'table', FILTER_DEFAULT);
$entity = filter_input(INPUT_POST, 'entity', FILTER_DEFAULT);
$parentName = filter_input(INPUT_POST, 'parent_name', FILTER_DEFAULT);

$Data['parent'] = filter_input(INPUT_POST, 'parent', FILTER_VALIDATE_INT);
$Data['atual'] = filter_input(INPUT_POST, 'atual', FILTER_VALIDATE_INT);
$Data['new'] = filter_input(INPUT_POST, 'new', FILTER_VALIDATE_INT);
$Data['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

require('../_app/Config.inc.php');
include_once ( '../_app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Order.Class.php');

$order = new Order($table, $entity, $parentName);
$order->ExeUpdate($Data);
if ($order->getResult()):
//    echo $order->getResult();
    echo 'ok';
endif;