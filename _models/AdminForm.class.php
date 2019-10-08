<?php

/**
 * AdminForm.class [ MODEL ADMIN ]
 * Responável por gerenciar os formulário do sismtea!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminForm {

    private $Data;
    private $Form;
    private $Result;
    private $Error;

    //Nome da tabela no banco de dados
    const Entity = 'forms';

    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->setData();
        $this->Create();
    }

    public function ExeUpdate($formId, array $Data) {
        $this->Form = (int) $formId;
        $this->Data = $Data;

        $this->setData();
        $this->Update();
    }

    public function ExeDelete($formId) {
        $this->Form = (int) $formId;

        $deleta = new Delete;
        $deleta->ExeDelete(self::Entity, "WHERE form_id = :formid", "formid={$this->Form}");

        $this->Error = ["Formulário removido com sucesso!", ACCEPT];
        $this->Result = true;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

    private function setData() {
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para criar um formulário, favor preencha todos os campos!", ALERT];
            $this->Result = false;
        endif;

        $this->Data['form_json'] = serialize(json_decode($this->Data['form_json']));
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);

        if ($Create->getResult()):
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE form_id = :id", "id={$this->Form}");
        if ($Update->getResult()):
            $this->Result = true;
        endif;
    }

}
