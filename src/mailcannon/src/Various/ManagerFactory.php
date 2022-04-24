<?php

namespace MailCannon\Various;


class ManagerFactory
{

    private static $managers = [
        "address"           => "\\Address\\AddressManager",
        "address_list"      => "\\AddressList\\AddressListManager",
        "message"           => "\\Message\\MessageManager"
    ];

    private array $loaded_managers;

    public function getManager(string $name) : DomainManager 
    {

        if(!empty($this->loaded_managers[$name])
        !empty(self::$managers[$name])) {

            $class_name                     = "\\MailCannon" . self::$managers[$name];
            $this->loaded_managers[$name]   = new $class_name();

            return $this->loaded_managers[$name];
        }
        else {

            throw new \BadMethodCallException($name . " manager does not exist");
        }
    }
}