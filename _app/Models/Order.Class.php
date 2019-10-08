<?php

/**
 * Order [ MODEL ]
 * Classe responsável por ordenar elementos
 * 
 * @copyright (c) 2016, Jean Reis RADIATI COMUNICAÇÃO
 */
class Order {

    private $Entity;
    private $Table;
    private $ParentName;
    private $Data;
    private $Result;

    function __construct($Table, $Entity, $ParentName = null) {
        $this->Table = $Table;
        $this->Entity = $Entity;
        $this->ParentName = $ParentName;
    }

    function getResult() {
        return $this->Result;
    }

    public function ExeUpdate(array $Data) {
        $this->Data = $Data;

        $this->setData();
        $this->exeOrder();

        $this->Result = true;
    }

    private function exeOrder() {

        if (isset($this->Data['parent']) && $this->ParentName != null):
            $this->withParent();
        elseif (!isset($this->Data['parent']) && $this->ParentName != null):
            $this->withoutParent();
        elseif (!isset($this->Data['parent']) && $this->ParentName == null):
            $this->generalUse();
        endif;
        
        $data = array("{$this->Entity}_order" => $this->Data['new']);
        $update = new Update;
        $update->ExeUpdate($this->Table, $data, "WHERE {$this->Entity}_id = :id", "id={$this->Data['id']}");
    }

    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        
        if(!empty($this->Data['parent'])):
            $this->Data['parent'] = $this->Data['parent'];
        else:
            unset($this->Data['parent']);
        endif;
    }

    private function withParent() {
        $orderUpdate = new Single;
        if ($this->Data['new'] > $this->Data['atual']):
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order - 1 WHERE {$this->ParentName} = :parent AND {$this->Entity}_order <= :new AND {$this->Entity}_order > :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":parent", $this->Data['parent']);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        else:
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order + 1 WHERE {$this->ParentName} = :parent AND {$this->Entity}_order >= :new AND {$this->Entity}_order < :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":parent", $this->Data['parent']);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        endif;
    }

    private function withoutParent() {
        $orderUpdate = new Single;
        if ($this->Data['new'] > $this->Data['atual']):
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order - 1 WHERE {$this->ParentName} IS NULL AND {$this->Entity}_order <= :new AND {$this->Entity}_order > :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        else:
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order + 1 WHERE {$this->ParentName} IS NULL AND {$this->Entity}_order >= :new AND {$this->Entity}_order < :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        endif;
    }
    
    private function generalUse() {
        $orderUpdate = new Single;
        if ($this->Data['new'] > $this->Data['atual']):
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order - 1 WHERE {$this->Entity}_order <= :new AND {$this->Entity}_order > :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        else:
            $Query = "UPDATE {$this->Table} SET {$this->Entity}_order = {$this->Entity}_order + 1 WHERE {$this->Entity}_order >= :new AND {$this->Entity}_order < :atual";
            $Exe = $orderUpdate->getConn()->prepare($Query);
            $Exe->bindValue(":atual", $this->Data['atual']);
            $Exe->bindValue(":new", $this->Data['new']);
            $Exe->execute();
        endif;
    }

}
