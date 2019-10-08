<?php

require('../_app/Config.inc.php');

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);

if (!empty($_FILES)):

    $ImageName = new Read;
    $ImageName->ExeRead('posts', "WHERE post_id = :id", "id={$postid}");

    if (!$ImageName->getResult()):
        $this->Error = ["Erro ao enviar galeria. O índice {$this->Post} não foi encontrado no banco!", ERROR];
        $this->Result = false;
    else:
        $ImageName = $ImageName->getResult()[0]['post_name'];

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
        $i = 0;
        $u = 0;

        foreach ($gbFiles as $gbUpload):
            $i++;
            $ImgName = "{$ImageName}-gb-{$postid}-" . md5(mt_rand() + $i);

            $gbSend->Image($gbUpload, $ImgName);

            if ($gbSend->getResult()):
                $position = new Read;
                $position->FullRead("SELECT MAX(gallery_order) FROM posts_gallery WHERE post_id = :id", "id={$postid}");
                $newImgOrder = $position->getResult()[0]['MAX(gallery_order)'] + 1;

                $gbImage = $gbSend->getResult();
                $gbCreate = ['post_id' => $postid, "gallery_image" => $gbImage, "gallery_date" => date('Y-m-d H:i:s'), 'gallery_order' => $newImgOrder];
                $insertGb = new Create;
                $insertGb->ExeCreate("posts_gallery", $gbCreate);
                $u++;
            endif;

        endforeach;
    endif;
endif;

$post_id = filter_input(INPUT_POST, 'post_id', FILTER_DEFAULT);
$post_video = filter_input(INPUT_POST, 'post_video', FILTER_DEFAULT);

if ((isset($post_video) && $post_video != '') && (isset($post_id) && $post_id != '')):
    $position = new Read;
    $position->FullRead("SELECT MAX(gallery_order) FROM posts_gallery WHERE post_id = :id", "id={$post_id}");
    $newImgOrder = $position->getResult()[0]['MAX(gallery_order)'] + 1;

    $gbCreateVideo = ['post_id' => $post_id, "gallery_image" => $post_video, "gallery_date" => date('Y-m-d H:i:s'), 'gallery_order' => $newImgOrder];
    $insertVideo = new Create;
    $insertVideo->ExeCreate("posts_gallery", $gbCreateVideo);
    if($insertVideo->getResult()):
        echo 'ok';
    endif;
endif;
?>