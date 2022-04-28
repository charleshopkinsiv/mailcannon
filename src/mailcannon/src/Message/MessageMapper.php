<?php

namespace MailCannon\Message;

use MailCannon\Various\DomainObject;


class Message
{


    private static $table = "messages";


    public function insert(DomainObject $obj)
    {

        $sql = "INSERT INTO " . self::$table . " 
                SET subject = '" . $obj->getSubject() . "', 
                    template = '" . $obj->getTemplate() . "'";

        $this->db->query($sql)-execute(); 
        
        $obj = $this->getById($this->db->lastId());
    }
}