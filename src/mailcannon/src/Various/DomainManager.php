<?php

namespace MailChimp\Various;


abstract class DomainManager
{

    abstract public function create(DomainObject $obj);
    abstract public function getById(int $id) : DomainObject;
    abstract public function update(DomainObject $obj);
    abstract public function delete(DomainObject $obj);
}