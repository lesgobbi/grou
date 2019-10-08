<?php

// sleep(1);

require('../_app/Config.inc.php');
$last = filter_input(INPUT_GET, 'last', FILTER_DEFAULT);

$ids = explode(',', $last);
array_pop($ids);

$i = 0;

$where = null;
foreach($ids as $id):
    $where .= "AND post_id != {$id} ";
    $i++;
endforeach;

$read = new Read;
$read->ExeRead('posts', "WHERE post_category = 1000 AND post_id != 3 {$where} ORDER BY post_date DESC LIMIT 6");

echo json_encode($read->getResult(), JSON_FORCE_OBJECT);

// echo '<pre>';
// print_r($read->getResult());
// echo '</pre>';