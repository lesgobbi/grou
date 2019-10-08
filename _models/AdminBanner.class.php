<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Responsável por gerenciar os posts no Banners do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminBanner {

    private $Data;
    private $Banner;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'banners';

    /**
     * <b>Cadastrar o Banner:</b> Envelope os dados do banner em um array atribuitivo e execute esse método
     * para cadastrar o banner.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (empty($this->Data['banner_url'])):
            $this->Error = ["Erro ao cadastrar: Para criar um banner, por favor faça upload de uma imagem!", ALERT];
            $this->Result = false;
        else:
            $this->setData();

            $position = new Read;
            $position->FullRead("SELECT MAX(banner_order) FROM " . self::Entity);
            $this->Data['banner_order'] = $position->getResult()[0]['MAX(banner_order)'] + 1;

            $this->Create();
        endif;
    }

    public function ExeUpdate($BannerId, array $Data) {
        $this->Banner = (int) $BannerId;
        $this->Data = $Data;
        
        $readBanner = new Read;
        $readBanner->ExeRead(self::Entity, "WHERE banner_id = :id", "id={$this->Banner}");

        if (isset($this->Data['banner_url'])):
            if ($this->Data['banner_url'] != $readBanner->getResult()[0]['banner_url']):
                $banner = HOME.'/uploads/' . $readBanner->getResult()[0]['banner_url'];
                if (file_exists($banner) && !is_dir($banner)):
                    unlink($banner);
                endif;
            endif;

            $this->Data['banner_url'] = $this->Data['banner_url'] ? $this->Data['banner_url'] : null;
        endif;

        if (empty($this->Data['banner_url'])):
            $this->Error = ["Erro ao atualizar: Para atualizar o banner, por favor faça upload de uma imagem!", ALERT];
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
        $ReadPost->ExeRead(self::Entity, "WHERE banner_id = :id", "id={$this->Banner}");

        if (!$ReadPost->getResult()):
            $this->Error = ["O post que você tentou deletar não existe no sistema!", ERROR];
            $this->Result = false;
        else:
            $PostDelete = $ReadPost->getResult()[0];
            if (file_exists(HOME.'/uploads/' . $PostDelete['banner_url']) && !is_dir(HOME.'/uploads/' . $PostDelete['banner_url'])):
                unlink(HOME.'/uploads/' . $PostDelete['banner_url']);
            endif;

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE banner_id = :id", "id={$this->Banner}");

            $this->Error = ["Banner removido com sucesso!", ACCEPT];
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

        if (isset($this->Data['banner_title'])):
            $Title = strip_tags($this->Data['banner_title']);
        endif;

        unset($this->Data['banner_title']);

        if (isset($this->Data['banner_subtitle'])):
            $subTitle = $this->Data['banner_subtitle'];
        endif;

        unset($this->Data['banner_subtitle']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        if (isset($Title)):
            $this->Data['banner_title'] = $Title;
        endif;

        if (isset($subTitle)):
            $this->Data['banner_subtitle'] = $subTitle;
        endif;

    }

    //Cadastra o banner no banco!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Result = $cadastra->getResult();
        endif;
    }

    //Atualiza o banner
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE banner_id = :id", "id={$this->Banner}");
        if ($Update->getResult()):
            $this->Result = true;
        endif;
    }

}
