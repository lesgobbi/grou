<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Responsável por gerenciar os posts no Items da Galeria do Selo do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminGaleriaSelo {

    private $Data;
    private $Banner;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'galeria_selo';

    /**
     * <b>Cadastrar o item:</b> Envelope os dados do item em um array atribuitivo e execute esse método
     * para cadastrar o item.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (empty($this->Data['galeria_url'])):
            $this->Error = ["Erro ao cadastrar: Para criar um item, por favor faça upload de uma imagem!", ALERT];
            $this->Result = false;
        else:
            $this->setData();

            $position = new Read;
            $position->FullRead("SELECT MAX(galeria_order) FROM " . self::Entity);
            $this->Data['galeria_order'] = $position->getResult()[0]['MAX(galeria_order)'] + 1;

            $this->Create();
        endif;
    }

    public function ExeUpdate($BannerId, array $Data) {
        $this->Banner = (int) $BannerId;
        $this->Data = $Data;

        if (isset($this->Data['galeria_url'])):
            
            $readBanner = new Read;
            $readBanner->ExeRead(self::Entity, "WHERE galeria_id = :id", "id={$this->Banner}");
            
            if ($this->Data['galeria_url'] != $readBanner->getResult()[0]['galeria_url']):
                $banner = HOME.'/uploads/' . $readBanner->getResult()[0]['galeria_url'];
                if (file_exists($banner) && !is_dir($banner)):
                    unlink($banner);
                endif;
            endif;

            $this->Data['galeria_url'] = $this->Data['galeria_url'] ? $this->Data['galeria_url'] : null;
        endif;

        if (empty($this->Data['galeria_url'])):
            $this->Error = ["Erro ao atualizar: Para atualizar por favor faça upload de uma imagem!", ALERT];
            $this->Result = false;
        else:
            $this->setData();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta Post:</b> Informe o ID do post a ser removido para que esse método realize uma checagem de
     * pastas e galerias excluinto todos os dados nessesários!
     * @param INT $PostId = Id do post
     */
    public function ExeDelete($bannerId) {
        $this->Banner = (int) $bannerId;

        $ReadPost = new Read;
        $ReadPost->ExeRead(self::Entity, "WHERE galeria_id = :id", "id={$this->Banner}");

        if (!$ReadPost->getResult()):
            $this->Error = ["O item que você tentou deletar não existe no sistema!", ERROR];
            $this->Result = false;
        else:
            $PostDelete = $ReadPost->getResult()[0];
            if (file_exists(HOME.'/uploads/' . $PostDelete['galeria_url']) && !is_dir(HOME.'/uploads/' . $PostDelete['galeria_url'])):
                unlink(HOME.'/uploads/' . $PostDelete['galeria_url']);
            endif;

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE galeria_id = :id", "id={$this->Banner}");

            $this->Error = ["Item removido com sucesso!", ACCEPT];
            $this->Result = true;

        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        if (isset($this->Data['galeria_title'])):
            $Title = strip_tags($this->Data['galeria_title']);
        endif;

        unset($this->Data['galeria_title']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        if (isset($Title)):
            $this->Data['galeria_title'] = $Title;
        endif;
    }

    //Cadastra no banco!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Result = $cadastra->getResult();
        endif;
    }

    //Atualiza
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE galeria_id = :id", "id={$this->Banner}");
        if ($Update->getResult()):
            $this->Result = true;
        endif;
    }

}
