<?php

namespace MailCannon\Various;


abstract class DomainManager
{

    protected SqlDataMapper $mapper;

    abstract public function update(DomainObject $obj);


    public function create(DomainObject $obj)
    {

        $this->mapper->insert($obj);
    }


    public function getById(int $id) : DomainObject
    {

        return $this->mapper->getById($id);
    }

    public function deleteById(DomainObject $obj)
    {

        $this->mapper->deleteById($obj->getId());
    }
}
