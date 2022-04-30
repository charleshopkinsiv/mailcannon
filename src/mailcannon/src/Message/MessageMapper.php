<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;


class MessageMapper extends SqlDataMapper
{

    protected $table = "message";

    public function insert(DomainObject &$obj)
    {

        $sql = "INSERT INTO " . $this->table . " 
                SET subject = '" . $obj->getSubject() . "', 
                    template = '" . $obj->getTemplate() . "'";

        $this->db->query($sql)->execute(); 
        
        $obj = $this->getById($this->db->lastId());
    }


    public function update(DomainObject $obj)
    {

        $sql = "UPDATE " . $this->table . " 
                SET subject = '" . $obj->getSubject() . "', 
                    template = '" . $obj->getTemplate() . "' 
                WHERE id = " . $obj->getId();

        $this->db->query($sql)->execute(); 
    }


    public function prepareObj(array $data) : DomainObject
    {

        return new Message(
            $data['id'],
            $data['subject'],
            $data['template']
        );
    }
}