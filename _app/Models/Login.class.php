<?php

/**
 * Login.class [ MODEL ]
 * Responável por autenticar, validar, e checar usuário do sistema de login!
 * 
 * @copyright (c) 2016, Jean Reis
 */
class Login {

    private $Level;
    private $Email;
    private $Senha;
    private $Nome;
    private $Error;
    private $Result;
    private $Registration;

    /**
     * <b>Informar Level:</b> Informe o nível de acesso mínimo para a área a ser protegida.
     * @param INT $Level = Nível mínimo para acesso
     */
    function __construct($Level) {
        $this->Level = (int) $Level;
    }

    /**
     * <b>Efetuar Login:</b> Envelope um array atribuitivo com índices STRING user [email], STRING pass.
     * Ao passar este array na ExeLogin() os dados são verificados e o login é feito!
     * @param ARRAY $UserData = user [email], pass
     */
    public function ExeLogin(array $UserData) {
        if (Check::Email($UserData['user'])):
            $this->Email = (string) strip_tags(trim($UserData['user']));
        else:
            $this->Nome = (string) strip_tags($UserData['user']);
        endif;
        $this->Senha = (string) strip_tags(($UserData['pass']));
        $this->setLogin();
    }

    public function ExeForgot(array $UserData) {
        if (Check::Email($UserData['email'])):
            $this->Email = (string) strip_tags(trim($UserData['email']));
            $this->CheckUser();
        else:
            $this->Error = ["O e-mail informado não é válido!", ALERT];
            $this->Result = false;
        endif;
    }

    public function ExeChangePass(array $UserData) {
        if (Check::Email($UserData['email'])):
            $this->Email = (string) strip_tags(trim($UserData['email']));
            $this->Senha = (string) strip_tags($UserData['password']);
            $this->setNewPass();
        else:
            $this->Error = ["O e-mail informado não é válido!", ALERT];
            $this->Result = false;
        endif;
    }

    /**
     * <b>Verificar Login:</b> Executando um getResult é possível verificar se foi ou não efetuado
     * o acesso com os dados.
     * @return BOOL $Var = true para login e false para erro
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com uma mensagem e um tipo de erro.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /**
     * <b>Checar Login:</b> Execute esse método para verificar a sessão USERLOGIN e revalidar o acesso
     * para proteger telas restritas.
     * @return BOLEAM $login = Retorna true ou mata a sessão e retorna false!
     */
    public function CheckLogin() {
        if (empty($_SESSION['userlogin-' . CLIENT_NAME]) || $_SESSION['userlogin-' . CLIENT_NAME]['user_level'] < $this->Level):
            unset($_SESSION['userlogin-' . CLIENT_NAME]);
            return false;
        else:
            return true;
        endif;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida os dados e armazena os erros caso existam. Executa o login!
    private function setLogin() {
//        if ((!$this->Email || !$this->Senha) || (!$this->Nome || !$this->Senha)):
//            $this->Error = ['Informe seu Nome ou E-mail e senha para efetuar o login!', ALERT];
//            $this->Result = false;
//        elseif (!$this->getUser()):
        if (!$this->getUser()):
            $this->Error = ['Os dados informados não são compatíveis!', ALERT];
            $this->Result = false;
        elseif ($this->Result['user_level'] < $this->Level):
            $this->Error = ["Desculpe {$this->Result['user_name']}, você não tem permissão para acessar esta área!", ERROR];
            $this->Result = false;
        else:
            $this->Execute();
        endif;
    }

    //Vetifica usuário no banco de dados e verifica compatibilidade da senha!
    private function getUser() {
        $this->Senha = $this->Senha;
        $read = new Read;
        if ($this->Nome):
            $read->ExeRead("users", "WHERE user_name = :n", "n={$this->Nome}");
        else:
            $read->ExeRead("users", "WHERE user_email = :e", "e={$this->Email}");
        endif;

        if ($read->getResult()):
            foreach ($read->getResult() as $u)
                ;
            if (password_verify($this->Senha, $u['user_password'])):
                $this->Result = $read->getResult()[0];
                return true;
            else:
                return false;
            endif;

        else:
            return false;
        endif;
    }

    //Executa o login armazenando a sessão!
    private function Execute() {
        if (!session_id()):
            session_start();
        endif;

        $_SESSION['userlogin-' . CLIENT_NAME] = $this->Result;

        $this->Error = ["Olá {$this->Result['user_name']}, seja bem vindo(a). Aguarde redirecionamento!", ACCEPT];
        $this->Result = true;
    }

    private function CheckUser() {
        $readUser = new Read;
        $readUser->ExeRead("users", "WHERE user_email = :mail", "mail={$this->Email}");
        if ($readUser->getRowCount()):
            foreach ($readUser->getResult() as $user):
                $name = $user['user_name'];
                $registration = $user['user_registration'];
                $this->sendRecovery($name, $registration);
            endforeach;
        else:
            $this->Error = ["Usuário não encontrado! Por favor informe seu e-mail corretamente.", ERROR];
            $this->Result = true;
        endif;
    }

    private function sendRecovery($name, $registration) {
        $Contato['Assunto'] = 'Recupere seu acesso!';
        $Contato['DestinoNome'] = $name;
        $Contato['DestinoEmail'] = $this->Email;
        $Contato['Mensagem'] = "Olá <strong>{$name}</strong>, foi feito um pedido de recuperação de acesso no nosso sistema, caso não tenha sido você, apenas ignore esta mensagem.<br><br>"
                . "Para recuperar seu acesso, clique no link abaixo<br><br>"
                . "<a href='" . HOME . "/admin/recovery.php?user=" . base64_encode($this->Email)
                . "*" . base64_encode($registration)
                . "*" . base64_encode($name)
                . "'>Recuperar acesso</a><br>";

        $SendMail = new Email;
        $SendMail->Enviar($Contato);

        if ($SendMail->getError()):
            $this->Error = ["Olá <strong>{$name}</strong>, acesse seu e-mail e siga as orientações de recuperação!", ACCEPT];
            $this->Result = true;
        endif;
    }
    
    private function setNewPass() {
        $newPass = new Update;
        $data['user_password'] = password_hash($this->Senha, PASSWORD_DEFAULT, ['cost' => 11]);
        $newPass->ExeUpdate("users", $data, "WHERE user_email = :email", "email={$this->Email}");
        if($newPass->getResult()):
            header('Location: login.php?exe=recovery');
            $this->Result = true;
        endif;
    }

}
