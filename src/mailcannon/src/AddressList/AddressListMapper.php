<?php

namespace MailCannon\AddressList;

use MailCannon\Various\DomainObject;
use MailCannon\Various\SqlDataMapper;
use MailCannon\Address\AddressLazySet;
use MailCannon\Address\AddressMapper;
use MailCannon\Address\Address;


class AddressListMapper extends SqlDataMapper
{

    protected string $table = "address_list";
    protected array $columns = [
        "name" => "getName"
    ];


    public function prepareObj(array $data) : DomainObject
    {

        return new AddressList(
            $data['id'],
            $data['name']
        );
    }


    public function getAddressesForList(AddressList $list) : AddressLazySet
    {

        $address_mapper = new AddressMapper();
        $address_mapper->where("id IN (SELECT al.address FROM address_list_links al WHERE address_list = " . $list->getId() . ")");
        $set = new AddressLazySet($address_mapper);
        return $set;
    }


    public function addAddressToList(AddressList $list, Address $address)
    {

        $sql = "INSERT IGNORE INTO address_list_links 
                    SET address_list = " . $list->getId() . ", 
                        address      = " . $address->getId();
        $this->db->query($sql)->execute();
    }


    public function removeAddressFromList(AddressList $list, Address $address)
    {

        $sql = "DELETE FROM address_list_links 
                WHERE address_list = " . $list->getId() . " 
                    AND address = " . $address->getId();
        $this->db->query($sql)->execute();
    }
}
