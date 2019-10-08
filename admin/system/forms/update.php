<div class="row">
    <div class="col-xs-12">
        <h3>Formulários</h3>
    </div>
</div>

<ol class="breadcrumb icon-home icon-angle-right">
    <li><a href="?exe=forms/forms">Formulários</a></li>
    <li>Novo Formulário</li>
</ol>

<?php

$postid = filter_input(INPUT_GET, 'postid', FILTER_VALIDATE_INT);
$atualizado = filter_input(INPUT_GET, 'atualizado', FILTER_VALIDATE_BOOLEAN);
if ($atualizado):
    Notification("Formulário atualizado com sucesso!", ACCEPT);
endif;

$formid = filter_input(INPUT_GET, 'formid', FILTER_VALIDATE_INT);
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($post) && isset($post['SendPostForm'])):
    unset($post['SendPostForm']);

    require('../_models/AdminForm.class.php');
    $atualiza = new AdminForm;
    $atualiza->ExeUpdate($formid, $post);

    if ($atualiza->getResult()):
        if(!$postid):
            header("Location: painel.php?exe=forms/update&formid={$formid}&atualizado=true");
        else:
            header("Location: painel.php?exe=posts/update&postid={$postid}&aform=true");
        endif;
    endif;
else:
    $read = new Read;
    $read->ExeRead("forms", "WHERE form_id = :id", "id={$formid}");
    $post = $read->getResult()[0];

    $objects = unserialize($post['form_json']);
    $json = json_encode($objects, true);

    echo '<script>';
    echo 'var initialData = ' . $json;
    echo '</script>';
endif;
?>


<div class="row m-b-40">
    <div class="col-xs-12 col-xl-6">
        <h4 class="m-b-20">Adicionar campo</h4>
        <div data-bind="foreach: fields">
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <fieldset class="form-group m-b-20">
                        <label>Nome do campo</label>
                        <input type="text" class="form-control" placeholder="label indicando nome do campo" required data-error="Insira o nome do campo" data-bind='value: name'>
                        <small class="help-block with-errors"></small>
                    </fieldset>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <label for="">Campo obrigatório</label>
                    <fieldset class="form-group">
                        <label class="c-input c-radio">
                            <input type="radio" value="0" required data-bind="checked: validate, attr: {name: radioName }">
                            <span class="c-indicator c-indicator-success"></span>
                            Não
                        </label>
                        <label class="c-input c-radio">
                            <input type="radio" value="1" required data-bind="checked: validate, attr: {name: radioName }">
                            <span class="c-indicator c-indicator-success"></span>
                            Sim
                        </label>
                    </fieldset>
                </div>
            </div>
            <div class="row m-b-20">
                <div class="col-xs-12 col-xl-6">
                    <fieldset class="form-group">
                        <label style="display: block">Tipo</label>
                        <select class="combo-select" name="" required data-bind="selectedOptions: type, event:{ change: $root.toggleViewCombo}">
                            <option value="text">campo de texto simples</option>
                            <option value="email">e-mail</option>
                            <option value="tel">número de telefone</option>
                            <option value="url">url (endereço de um site)</option>
                            <option value="data">data</option>
                            <option value="textarea">caixa de texto (multiplas linhas)</option>
                            <option value="check">checkbox (multiplas opções)</option>
                            <option value="radio">radio (opção única)</option>
                            <option value="combo">opções selecionáveis (dropdown)</option>
                        </select>
                    </fieldset>
                </div>
                <div class="col-xs-12 col-xl-6">
                    <a class="btn btn-danger like-a-trash" data-bind='click: $root.removeField' style="margin-top: 18px;">
                        <i class="fa fa-remove"></i>
                        Remover campo
                    </a>
                </div>
            </div>

            <div data-bind="visible: optionsView">
                <div class="col-xs-12 col-xl-12" style="padding: 0;">
                    <label style="display: block;">Adicionar opção</label>
                </div>
                <div data-bind="foreach: options">
                    <div class="row">
                        <div class="col-xs-12 col-xl-6">
                            <fieldset class="form-group m-b-10">
                                <input type="text" class="form-control" placeholder="infome a opção" data-bind="value: option, event:{ blur: $root.updateJson}">
                                <small class="help-block with-errors"></small>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-xl-6">
                            <a class="btn btn-danger like-a-trash remove-fieald-combo m-r-10" data-bind='click: $root.removeOption'>
                                <i class="fa fa-remove"></i>
                                Remover
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-xl-12">
                        <a class="btn btn-success like-a-trash plus-fieald-combo m-b-20" data-bind='click: $root.addOption'>
                            <i class="fa fa-plus"></i>
                            Adicionar
                        </a>
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <div class="row">
            <div class="col-xs-12 col-xl-12 m-b-20 m-t-10">
                <a class="btn btn-success like-a-trash" data-bind='click: addField'>
                    <i class="fa fa-plus"></i>
                    Adicionar campo
                </a>
            </div>
        </div>

        <form name="form-cad" method="post">
            <div class="row">
                <div class="col-xs-12 col-xl-6">
                    <div class="form-group floating-labels">
                        <label for="email_contato">E-mail Destino</label>
                        <input id="email_contato" autocomplete="off" type="email" name="form_destino" value="<?php if (!empty($post['form_destino'])) echo $post['form_destino']; ?>" required>
                        <p class="error-block"></p>
                    </div>

                    <?php if(!$postid): ?>
                        <div class="form-group floating-labels">
                            <label for="form_nome">Nome do Formulário</label>
                            <input id="form_nome" autocomplete="off" type="text" name="form_nome" value="<?php if (!empty($post['form_nome'])) echo $post['form_nome']; ?>" required>
                            <p class="error-block"></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <textarea data-bind='value: savedJson' style="display: none;" name="form_json" value="<?php if (!empty($post['form_json'])) echo $post['form_json']; ?>"></textarea>
                <input type="submit" class="btn btn-primary m-r-10 m-b-10" value="Atualizar Formulário" name="SendPostForm" data-bind="event:{ mouseover: $root.changes}"/>
                <?php if($postid): ?>
                    <a class="btn btn-primary m-r-10 m-b-10" href="?exe=posts/update&postid=<?= $postid; ?>">Voltar para página</a>
                <?php endif; ?>
            </div>
        </form>

    </div>
</div>

<script src="<?= CDN; ?>/scripts/components/knockout.js"></script>