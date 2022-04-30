<?php

namespace MailCannon\Address;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;


class AddressMapper extends SqlDataMapper
{

    protected $table = "address";

    public function insert(DomainObject &$obj)
    {

        $sql = "INSERT INTO " . $this->table . " 
                SET username = '" . $obj->getUsername() . "', 
                    domain   = '" . $obj->getDomain() . "',
                    name     = '" . $obj->getName() . "'";

        $this->db->query($sql)->execute(); 
        
        $obj = $this->getById($this->db->lastId());
    }


    public function update(DomainObject $obj)
    {

        $sql = "UPDATE " . $this->table . " 
                SET username = '" . $obj->getUsername() . "', 
                    domain   = '" . $obj->getDomain() . "',
                    name     = '" . $obj->getName() . "' 
                WHERE id = " . $obj->getId();

        $this->db->query($sql)->execute(); 
    }


    public function prepareObj(array $data) : DomainObject
    {

        return new Address(
            $data['id'],
            $data['username'],
            $data['domain'],
            $data['name']
        );
    }
}