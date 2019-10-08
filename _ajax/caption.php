<?php

$table = filter_input(INPUT_POST, 'table', FILTER_DEFAULT);
$entity = filter_input(INPUT_POST, 'entity', FILTER_DEFAULT);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$caption = filter_input(INPUT_POST, 'caption', FILTER_DEFAULT);

require('../_app/Config.inc.php');

$text["{$entity}_caption"] = $caption;

$update = new Update;
$update->ExeUpdate($table, $text, "WHERE {$entity}_id = :id", "id={$id}");

if ($update->getResult()):
    echo 'ok';
endif;
