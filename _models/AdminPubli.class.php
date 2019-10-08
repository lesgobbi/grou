<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os posts no Admin do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminPubli {

    private $Data;
    private $Post;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'publicidade';

    public function ExeUpdate($PostId, array $Data) {
        $this->Post = (int) $PostId;
        $this->Data = $Data;

        if (isset($this->Data['publicidade_start'])):
            $this->Data['publicidade_start'] = Check::Data($this->Data['publicidade_start']);
        endif;
        
        if (isset($this->Data['publicidade_end'])):
            $this->Data['publicidade_end'] = Check::Data($this->Data['publicidade_end']);
        endif;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar este anuncio envie a imagem", ALERT];
            $this->Result = false;
        else:

            if (isset($this->Data['image'])):
                $this->checkImage();
                $this->uploadImage();
            endif;

            $this->Update();
            
        endif;
    }
    
    public function ExeClear($PostId){
        
        $this->Post = (int) $PostId;

        $ReadPost = new Read;
        $ReadPost->ExeRead(self::Entity, "WHERE publicidade_id = :post", "post={$this->Post}");

        $PostDelete = $ReadPost->getResult()[0];
        if ($PostDelete['publicidade_content'] && file_exists(HOME.'/uploads/' . $PostDelete['publicidade_content']) && !is_dir(HOME.'/uploads/' . $PostDelete['publicidade_content'])):
            unlink(HOME.'/uploads/' . $PostDelete['publicidade_content']);
        endif;

        $this->Data['publicidade_title'] = NULL;
        $this->Data['publicidade_content'] = NULL;
        $this->Data['publicidade_start'] = '0000-00-00';
        $this->Data['publicidade_end'] = '0000-00-00';

        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE publicidade_id = :id", "id={$this->Post}");

        $this->Error = ["Removido com sucesso!", ACCEPT];
        $this->Result = true;
        
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna ID do registro se o cadastro for efetuado ou FALSE se não.
     * Para verificar erros execute um getError();
     * @return BOOL $Var = InsertID or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com uma mensagem e o tipo de erro.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    //Atualiza o post no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE publicidade_id = :id", "id={$this->Post}");
        if ($Update->getResult()):
            $this->Error = ["Atualizado com sucesso no sistema!", ACCEPT];
            $this->Result = true;
        endif;
    }
    
    private function uploadImage() {
        if (!empty($this->Data['image']['tmp_name'])):
            $Upload = new Upload;
            $Upload->Image($this->Data['image'], md5(date('d/m/Y H:i:s')), 450);
            
            if ($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Data['publicidade_content'] = $Upload->getResult();
                unset($this->Data['image']);
                $this->Result = true;
            endif;
        endif;
    }
    
    private function checkImage() {
        $readImage = new Read;
        $readImage->ExeRead("publicidade", "WHERE publicidade_id = :id", "id={$this->Post}");

        if ($readImage->getRowCount()):
            $delImage = $readImage->getResult()[0]['publicidade_content'];
            if (file_exists(HOME."/uploads/{$delImage}") && !is_dir(HOME."/uploads/{$delImage}")):
                unlink(HOME."/uploads/{$delImage}");
            endif;
        endif;
    }

}
