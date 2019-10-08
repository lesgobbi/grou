<?php

require('../_app/Config.inc.php');

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

if (!empty($_FILES)):

    $dados = $_FILES['gallery_covers'];

    $gbFiles = array();
    $gbCount = count($dados['tmp_name']);
    $gbKeys = array_keys($dados);

    for ($gb = 0; $gb < $gbCount; $gb++):
        foreach ($gbKeys as $Keys):
            $gbFiles[$gb][$Keys] = $dados[$Keys][$gb];
        endforeach;
    endfor;
    
    $gbSend = new Upload;
    $u = 0;
    $caption = null;

    foreach ($gbFiles as $gbUpload):
        $name = Check::Name($gbUpload[$u]['name']);
        
        $gbSend->Image($gbUpload, $name);

        if ($gbSend->getResult()):
            $position = new Read;
            $position->FullRead("SELECT MAX(gallery_order) FROM posts_gallery WHERE category_id = :id", "id={$postid}");
            $newImgOrder = $position->getResult()[0]['MAX(gallery_order)'] + 1;

            $gbImage = $gbSend->getResult();
            $fName = $gbSend->getName();
            $gbCreate = ['category_id' => $postid, "gallery_image" => $gbImage, "gallery_date" => date('Y-m-d H:i:s'), 'gallery_order' => $newImgOrder, 'gallery_caption' => $fName];
            $insertGb = new Create;
            $insertGb->ExeCreate("posts_gallery", $gbCreate);
            $u++;
        endif;

    endforeach;
endif;
?>