<?php

/**
 * Contato.class [ Contato ]
 * Envio de email de contato
 * @copyright (c) 2016, Jean Reis
 */
class Contato {

    private $Data;
    private $Error;
    private $Result;
    private $Form;

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    public function Envia(array $Data, $formid = null) {
        $this->Data = $Data;
        $this->Form = $formid;
        $this->setData();
        $this->send();
    }

    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
    }

    private function send() {
        $read = new Read;
        
        $general = $read;
        $general->ExeRead('general');
        $sender = $general->getResult()[0]['title'];


        $this->Form = $this->Form ? $this->Form : 1;

        $destino = $read;
        $destino->ExeRead("forms", "WHERE form_id = :id", "id={$this->Form}");

        $Contato['DestinoEmail'] = $destino->getResult()[0]['form_destino'];
        // $Contato['DestinoEmail'] = 'jeanpreis@gmail.com';

        if($this->Form != 1):
            $Contato['Assunto'] = 'Nova cotação online - '.CLIENT_NAME;
        else:
            $Contato['Assunto'] = 'Novo contato - '.CLIENT_NAME;
        endif;

        $Contato['DestinoNome'] = 'Administrador';
        $Contato['Mensagem'] = '<h2>'. $Contato['Assunto'] .'</h2><p style="line-height: 1.5;">';

        foreach ($this->Data as $key => $value):
            $Contato['Mensagem'] .= '<strong>'.ucfirst(str_replace('-', ' ', $key)).':</strong> ' . $value . '<br>';
        endforeach;
        $Contato['Mensagem'] .= '</p>';

//        echo '<pre>';
//        print_r($Contato);
//        echo '</pre>';
//        exit;

        $SendMail = new Email;
        $SendMail->Enviar($Contato, $sender);

        if ($SendMail->getError()):
            $this->Result = true;
            $this->Error = true;
        endif;
    }

}
