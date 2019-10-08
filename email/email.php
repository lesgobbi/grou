<?php

require('../_app/Config.inc.php');

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (isset($post)):
    $contato = new Contato;
    unset($post['sendForm']);
    $contato->Envia($post);
    if ($contato->getError()):
        echo 'Mensagem enviada com sucesso! Entraremos em contato assim que possível';
    endif;
endif;
?>