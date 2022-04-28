<?php

namespace MailCannon\Various;


abstract class DomainManager
{

    protected SqlDataMapper $mapper;


    public function create(&DomainObject $obj)
    {

        $this->mapper->insert($obj);
    }


    public function getById(int $id) : DomainObject
    {

        return $this->mapper->getById($id);
    }


    public function update(&DomainObject $obj)
    {

        $this->mapper->update($obj);
    }


    public function delete(&DomainObject $obj)
    {

        $this->mapper->deleteById($obj->getId());
    }
}
