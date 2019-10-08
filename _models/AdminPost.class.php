<?php

/**
 * AdminPost.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os posts no Admin do sistema!
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class AdminPost {

    private $Data;
    private $Post;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'posts';

    /**
     * <b>Cadastrar o Post:</b> Envelope os dados do post em um array atribuitivo e execute esse método
     * para cadastrar o post. Envia a capa automaticamente!
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {

        if (empty($Data['post_cover'])):
            unset($Data['post_cover']);
        endif;

        if (empty($Data['post_content'])):
            unset($Data['post_content']);
        endif;

        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao cadastrar: Para criar um post, favor preencha todos os campos!", ALERT];
            $this->Result = false;
        else:
            if (isset($this->Data['pdf'])):
                $this->uploadPdf();
            endif;
            
            $this->setData();
            $this->setName();

            $this->Data['post_cover'] = $this->Data['post_cover'] ? $this->Data['post_cover'] : null;

            $position = new Read;
            $position->FullRead("SELECT MAX(post_order) FROM " . self::Entity . " WHERE post_category = " . $this->Data['post_category']);
            $this->Data['post_order'] = $position->getResult()[0]['MAX(post_order)'] + 1;

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

        if (empty($Data['post_cover'])):
            unset($Data['post_cover']);
        endif;

        if (empty($Data['post_content'])):
            unset($Data['post_content']);
        endif;

        if (empty($Data['post_subtitle'])):
            unset($Data['post_subtitle']);
        endif;

        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ["Para atualizar este post, preencha todos os campos ( Capa não precisa ser enviada! )", ALERT];
            $this->Result = false;
        else:

            if (isset($this->Data['pdf'])):
                $this->checkPdf();
                $this->uploadPdf();
            endif;

            $this->setData();
            $this->setName();

            $readCapa = new Read;
            $readCapa->ExeRead(self::Entity, "WHERE post_id = :post", "post={$this->Post}");

            if (isset($this->Data['post_cover'])):
                if ($this->Data['post_cover'] != $readCapa->getResult()[0]['post_cover']):
                    $capa = UPLOAD_ROOT.'/uploads/' . $readCapa->getResult()[0]['post_cover'];
                    if (file_exists($capa) && !is_dir($capa)):
                        unlink($capa);
                    endif;
                endif;

                $this->Data['post_cover'] = $this->Data['post_cover'] ? $this->Data['post_cover'] : null;
            endif;

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
        $ReadPost->ExeRead(self::Entity, "WHERE post_id = :post", "post={$this->Post}");

        if (!$ReadPost->getResult()):
            $this->Error = ["O post que você tentou deletar não existe no sistema!", ERROR];
            $this->Result = false;
        else:
            $PostDelete = $ReadPost->getResult()[0];
            if ($PostDelete['post_cover'] && file_exists(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover']) && !is_dir(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover'])):
                unlink(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover']);
            endif;

            if ($PostDelete['post_content'] && file_exists(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content']) && !is_dir(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content'])):
                unlink(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content']);
            endif;

            $deleta = new Delete;
            $deleta->ExeDelete(self::Entity, "WHERE post_id = :postid", "postid={$this->Post}");

            $this->gbRemoveByPost();

            $this->Error = ["O post <b>{$PostDelete['post_title']}</b> foi removido com sucesso do sistema!", ACCEPT];
            $this->Result = true;

        endif;
    }

    //TODO
    public function ExeRemoveImg($PostId) {
        $this->Post = (int) $PostId;

        $ReadPost = new Read;
        $ReadPost->ExeRead(self::Entity, "WHERE post_id = :post", "post={$this->Post}");

        $PostDelete = $ReadPost->getResult()[0];
        
        if ($PostDelete['post_cover'] && file_exists(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover']) && !is_dir(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover'])):
            unlink(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_cover']);
        endif;

        // if ($PostDelete['post_content'] && file_exists(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content']) && !is_dir(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content'])):
        //     unlink(UPLOAD_ROOT.'/uploads/' . $PostDelete['post_content']);
        // endif;

        $deleta = new Update;
        $cleam['post_cover'] = '';
        $deleta->ExeUpdate(self::Entity, $cleam, "WHERE post_id = :postid", "postid={$this->Post}");

        $this->Result = true;
    }

    /**
     * <b>Ativa/Inativa Post:</b> Informe o ID do post e o status e um status sendo 1 para ativo e 0 para
     * rascunho. Esse méto ativa e inativa os posts!
     * @param INT $PostId = Id do post
     * @param STRING $PostStatus = 1 para ativo, 0 para inativo
     */
    public function ExeStatus($PostId, $PostStatus) {
        $this->Post = (int) $PostId;
        $this->Data['post_status'] = (string) $PostStatus;
        if ($this->Data['post_status'] == 0):
            $this->Data['post_featured'] = 0;
        endif;
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE post_id = :id", "id={$this->Post}");
    }

    public function ExeFeatured($PostId, $PostFeatured) {
        $this->Post = (int) $PostId;
        $this->Data['post_featured'] = (int) $PostFeatured;
        if ($this->Data['post_featured'] == 1):
            $this->Data['post_status'] = 1;
        endif;
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE post_id = :id", "id={$this->Post}");
    }

    /**
     * <b>Deletar Imagem da galeria:</b> Informe apenas o id da imagem na galeria para que esse método leia e remova
     * a imagem da pasta e delete o registro do banco!
     * @param INT $GbImageId = Id da imagem da galleria
     */
    public function gbRemove($GbImageId) {
        $this->Post = (int) $GbImageId;
        $readGb = new Read;
        $readGb->ExeRead("posts_gallery", "WHERE gallery_id = :gb", "gb={$this->Post}");
        if ($readGb->getResult()):

            $Imagem = UPLOAD_ROOT.'/uploads/' . $readGb->getResult()[0]['gallery_image'];

            if (file_exists($Imagem) && !is_dir($Imagem)):
                unlink($Imagem);
            endif;

            $Deleta = new Delete;
            $Deleta->ExeDelete("posts_gallery", "WHERE gallery_id = :id", "id={$this->Post}");
            if ($Deleta->getResult()):
                $this->Error = ["A imagem foi removida com sucesso da galeria!", ACCEPT];
                $this->Result = true;
            endif;

        endif;
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

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        if (isset($this->Data['post_cover'])):
            $Cover = $this->Data['post_cover'];
        endif;

        if (isset($this->Data['post_content'])):
            $Content = $this->Data['post_content'];
        endif;

        if (isset($this->Data['post_content']) && empty($this->Data['post_content'])):
            $Content = null;
        endif;

        if (isset($this->Data['post_subtitle'])):
            $SubTitle = $this->Data['post_subtitle'];
        endif;

        unset($this->Data['post_cover'], $this->Data['post_content'], $this->Data['post_subtitle']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['post_name'] = Check::Name($this->Data['post_title']);
        $this->Data['post_date'] = Check::Data($this->Data['post_date']);
        $this->Data['post_type'] = 'post';
        if (isset($Cover)):
            $this->Data['post_cover'] = $Cover;
        endif;

        if (isset($Content)):
            $this->Data['post_content'] = $Content;
        else:
            $this->Data['post_content'] = null;
        endif;

        if (isset($SubTitle)):
            $this->Data['post_subtitle'] = $SubTitle;
        endif;
    }

    //Obtem o ID da categoria PAI
    private function getCatParent() {
        $rCat = new Read;
        $rCat->ExeRead("categories", "WHERE category_id = :id", "id={$this->Data['post_category']}");
        if ($rCat->getResult()):
            return $rCat->getResult()[0]['category_parent'];
        else:
            return null;
        endif;
    }

    //Verifica o NAME post. Se existir adiciona um pós-fix -Count
    private function setName() {
        $Where = (isset($this->Post) ? "post_id != {$this->Post} AND" : '');
        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} post_title = :t", "t={$this->Data['post_title']}");
        if ($readName->getResult()):
            $this->Data['post_name'] = $this->Data['post_name'] . '-' . $readName->getRowCount();
        endif;
    }

    //Cadastra o post no banco!
    private function Create() {
        $cadastra = new Create;
        $cadastra->ExeCreate(self::Entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Error = ["O post {$this->Data['post_title']} foi cadastrado com sucesso no sistema!", ACCEPT];
            $this->Result = $cadastra->getResult();
        endif;
    }

    //Atualiza o post no banco!
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE post_id = :id", "id={$this->Post}");
        if ($Update->getResult()):
            $this->Error = ["O post <b>{$this->Data['post_title']}</b> foi atualizado com sucesso no sistema!", ACCEPT];
            $this->Result = true;
        endif;
    }

    /**
     * <b>Deleta Imagens da galeria baseado no ID de um post:</b> Informe apenas o id do post
     */
    private function gbRemoveByPost() {
        $readGallery = new Read;
        $readGallery->ExeRead('posts_gallery', "WHERE post_id = :post_id", "post_id={$this->Post}");
        if ($readGallery->getRowCount()):
            foreach ($readGallery->getResult() as $gallery):
                $this->gbRemove($gallery['gallery_id']);
            endforeach;
        endif;
    }
    
    private function uploadPdf() {
        if (!empty($this->Data['pdf']['tmp_name'])):
            $Upload = new Upload;
            $Upload->File($this->Data['pdf'], substr(Check::Name($this->Data['pdf']['name']), 0, -4), null, 50);
            
            if ($Upload->getError()):
                $this->Error = $Upload->getError();
                $this->Result = false;
            else:
                $this->Data['post_content'] = $Upload->getResult();
                unset($this->Data['pdf']);
                $this->Result = true;
            endif;
        endif;
    }
    
    private function checkPdf() {
        $readPdf = new Read;
        $readPdf->ExeRead("posts", "WHERE post_id = :id", "id={$this->Post}");

        if ($readPdf->getRowCount()):
            $delPdf = $readPdf->getResult()[0]['post_content'];
            if (file_exists(UPLOAD_ROOT."/uploads/{$delPdf}") && !is_dir(UPLOAD_ROOT."/uploads/{$delPdf}")):
                unlink(UPLOAD_ROOT."/uploads/{$delPdf}");
            endif;
        endif;
    }

}
