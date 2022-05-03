<?php

namespace MailCannon\Address;

use MailCannon\Address\AddressMapper;

class AddressLazySet implements \Iterator 
{

    protected Address $current_item;
    protected int $key;

    public function __construct(AddressMapper $mapper)
    {

        $this->mapper           = $mapper;
        $this->rewind();
    }


    public function current()
    {

        return $this->current_item;
    }


    public function key()
    {

        return $this->pointer;
    }


    public function next()
    {

        if($next = $this->mapper->fetchNext()) {

            $this->current_item = $next;
            $this->key++;
        }
        else {
            
            unset($this->current_item);
        }
    }


    public function rewind()
    {

        if($current_item = $this->mapper->fetchFirst()) {

            $this->current_item = $current_item;
        }

        $this->key              = 0;
    }


    public function valid()
    {
        
        return isset($this->current_item);
    }
}
