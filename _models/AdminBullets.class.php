<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os bullets no Admin do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminBullets {

    private $Data;
    private $Post;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'bullets';

    /**
     * <b>Cadastrar o Post:</b> Envelope os dados do post em um array atribuitivo e execute esse método
     * para cadastrar o post. Envia a capa automaticamente!
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para criar um destaque, favor preencha todos os campos!", ALERT];
            $this->Result = false;
        else:
            $this->setData();
           
            $position = new Read;
            $position->FullRead("SELECT MAX(bullet_order) FROM ".self::Entity. " WHERE post_id = ".$this->Data['post_id']);
            $this->Data['bullet_order'] = $position->getResult()[0]['MAX(bullet_order)'] + 1;

            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar Post:</b> Envelope os dados em uma array atribuitivo e informe o id de um 
     * post para atualiza-lo na tabela!
     * @param INT $PostId = Id do post
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($PostId, array $Data) {
        $this->Post = (int) $PostId;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar, preencha todos os campos ( Capa não precisa ser enviada! )", ALERT];
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
    public function ExeDelete($PostId) {
        $this->Post = (int) $PostId;

        $ReadPost = new Read;
        $ReadPost->ExeRead(self::Entity, "WHERE bullet_id = :post", "post={$this->Post}");

        if (!$ReadPost->getResult()):
            $this->Error = ["O bullet que você tentou deletar não existe no sistema!", ERROR];
            $this->Result = false;
        else:
            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE bullet_id = :postid", "postid={$this->Post}");

            $this->Error = ["Removido com sucesso!", ACCEPT];
            $this->Result = true;

        endif;
    }

    
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

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        if (isset($this->Data['bullet_content'])):
            $Content = $this->Data['bullet_content'];
        endif;

        unset($this->Data['bullet_content']);
        
        if (isset($this->Data['bullet_date_start'])):
            $this->Data['bullet_date_start'] = Check::Data($this->Data['bullet_date_start']);
        endif;
        
        if (isset($this->Data['bullet_date_end'])):
            $this->Data['bullet_date_end'] = Check::Data($this->Data['bullet_date_end']);
        endif;

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        if (isset($Content)):
            $this->Data['bullet_content'] = $Content;
        endif;
    }

    //Cadastra o post no banco!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);

        if ($cadastra->getResult()):
            $this->Error = ["O bullet {$this->Data['bullet_title']} foi cadastrado com sucesso no sistema!", ACCEPT];
            $this->Result = $cadastra->getResult();
        endif;
    }

    //Atualiza o post no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE bullet_id = :id", "id={$this->Post}");
        if ($Update->getResult()):
            $this->Error = ["<b>{$this->Data['bullet_title']}</b> foi atualizado com sucesso no sistema!", ACCEPT];
            $this->Result = true;
        endif;
    }
}
