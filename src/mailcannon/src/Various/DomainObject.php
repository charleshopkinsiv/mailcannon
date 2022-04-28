<?php

namespace MailCannon\Various;


abstract public class DomainObject 
{

    protected int $id;

    abstract public function getId(): int
}