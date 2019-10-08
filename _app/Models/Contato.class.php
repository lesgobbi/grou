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

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    public function Envia(array $Data) {
        $this->Data = $Data;
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
        
        $wf = explode('form-', $this->Data['form-name']);
        unset($this->Data['form-name']);

        $destino = $read;
        $destino->ExeRead("forms", "WHERE form_id = :id", "id=2");

        $Contato['DestinoEmail'] = $destino->getResult()[0]['form_destino'];
        // $Contato['DestinoEmail'] = 'jeanpreis@gmail.com';

        if($wf[1] == '2'):
            $Contato['Assunto'] = 'Novo contato (fale conosco) - '.CLIENT_NAME;
        elseif($wf[1] == '3'):
            $Contato['Assunto'] = 'Nova contato (mapa) - '.CLIENT_NAME;
        endif;

        $Contato['DestinoNome'] = 'Administrador';
        $Contato['Mensagem'] = '<h2>'. $Contato['Assunto'] .'</h2><p style="line-height: 1.5;">';

        foreach ($this->Data as $key => $value):
            
            if($key == 'quero' && $value == 1):
                $value = 'Comprar';
            elseif($key == 'quero' && $value == 2):
                $value = 'Ser representante';
            endif;
            
            $Contato['Mensagem'] .= '<strong>'.ucfirst(str_replace('-', ' ', $key)).':</strong> ' . $value . '<br>';
            
        endforeach;
        
        $Contato['Mensagem'] .= '</p>';

        $SendMail = new Email;
        $SendMail->Enviar($Contato, $sender);

        if ($SendMail->getError()):
            $this->Result = true;
            $this->Error = true;
        endif;
    }

}
