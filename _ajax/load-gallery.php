<?php
require('../_app/Config.inc.php');
$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
// $postid = 3;

$read = new Read;
$read->ExeRead('posts_gallery', "WHERE post_id = :id ORDER BY gallery_order ASC", "id={$postid}");

$i = 0;
foreach($read->getResult() as $itens):
    $output[$i]['img'] = HOME . '/uploads/' . $itens['gallery_image'];
    $output[$i]['thumb'] = HOME . '/uploads/' . $itens['gallery_image'];
    $output[$i]['caption'] = $itens['gallery_caption'];
    $i++;
endforeach;

echo json_encode($output, JSON_FORCE_OBJECT);