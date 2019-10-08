<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Responsável por gerenciar os posts no Banners do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminGeneral {

    private $Data;
    private $Error;
    private $Result;
    private $Social;

    //Nome da tabela no banco de dados
    const Entity = 'general';

    public function ExeUpdate(array $Data) {
        $this->Data = $Data;
        

        $readLogo = new Read;
        $readLogo->ExeRead(self::Entity);

        if (isset($this->Data['logo'])):
            if ($this->Data['logo'] != $readLogo->getResult()[0]['logo']):
                $logo = HOME.'/uploads/' . $readLogo->getResult()[0]['logo'];
                if (file_exists($logo) && !is_dir($logo)):
                    unlink($logo);
                endif;
            endif;
        endif;

        $this->clearSocial();

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar, preencha todos os campos", ALERT];
            $this->Result = false;
        else:

            $this->setSocial();
            $this->setData();
            $this->Data['id'] = 1;
            
            $this->Update();
            
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

    private function clearSocial() {
        if ($this->Data['social_fb']):
            $this->Social['social_fb'] = $this->Data['social_fb'];
        endif;

        if ($this->Data['social_tt']):
            $this->Social['social_tt'] = $this->Data['social_tt'];
        endif;

        if ($this->Data['social_yt']):
            $this->Social['social_yt'] = $this->Data['social_yt'];
        endif;

        if ($this->Data['social_ig']):
            $this->Social['social_ig'] = $this->Data['social_ig'];
        endif;

        if ($this->Data['social_li']):
            $this->Social['social_li'] = $this->Data['social_li'];
        endif;

        if ($this->Data['social_pr']):
            $this->Social['social_pr'] = $this->Data['social_pr'];
        endif;

        if ($this->Data['social_gp']):
            $this->Social['social_gp'] = $this->Data['social_gp'];
        endif;

        unset($this->Data['social_fb'], $this->Data['social_tt'], $this->Data['social_yt'], $this->Data['social_ig']);
        unset($this->Data['social_li'], $this->Data['social_pr'], $this->Data['social_gp']);
    }

    private function setSocial() {
        if (isset($this->Social['social_fb'])):
            $this->Data['social_fb'] = $this->Social['social_fb'];
        else:
            $this->Data['social_fb'] = NULL;
        endif;

        if (isset($this->Social['social_tt'])):
            $this->Data['social_tt'] = $this->Social['social_tt'];
        else:
            $this->Data['social_tt'] = NULL;
        endif;

        if (isset($this->Social['social_yt'])):
            $this->Data['social_yt'] = $this->Social['social_yt'];
        else:
            $this->Data['social_yt'] = NULL;
        endif;

        if (isset($this->Social['social_ig'])):
            $this->Data['social_ig'] = $this->Social['social_ig'];
        else:
            $this->Data['social_ig'] = NULL;
        endif;

        if (isset($this->Social['social_li'])):
            $this->Data['social_li'] = $this->Social['social_li'];
        else:
            $this->Data['social_li'] = NULL;
        endif;

        if (isset($this->Social['social_pr'])):
            $this->Data['social_pr'] = $this->Social['social_pr'];
        else:
            $this->Data['social_pr'] = NULL;
        endif;

        if (isset($this->Social['social_gp'])):
            $this->Data['social_gp'] = $this->Social['social_gp'];
        else:
            $this->Data['social_gp'] = NULL;
        endif;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE id = :id", "id={$this->Data['id']}");
        if ($Update->getResult()):
            $this->Result = true;
            $this->Error = $this->Data['id'];
        else:
            $this->Result = false;
        endif;
    }

}
