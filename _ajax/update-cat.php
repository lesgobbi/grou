<?php
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
require('../_app/Config.inc.php');

if(isset($_POST['category'])):
    
    $clearCats = new Delete;
    $clearCats->ExeDelete('gallery_categories', 'WHERE gallery_id = :gid', "gid={$id}");

    if(!empty($_POST['category'])):
        $cadCat = new Create;
        foreach($_POST['category'] as $cats):
            $data['gallery_id'] = $id;
            $data['category_id'] = $cats;
            $cadCat->ExeCreate('gallery_categories', $data);
        endforeach;
    endif;
endif;