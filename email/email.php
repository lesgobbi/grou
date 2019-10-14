<?php

require('../_app/Config.inc.php');

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$formId = filter_input(INPUT_GET, 'formid', FILTER_VALIDATE_INT);
if (isset($post)):
    $contato = new Contato;
    unset($post['SendContato']);
    unset($post['sendForm']);
    $contato->Envia($post, $formId);
    if ($contato->getError()):
        echo 'Mensagem enviada com sucesso! Entraremos em contato assim que possível';
    endif;
endif;
?>