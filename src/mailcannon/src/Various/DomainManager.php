<?php

namespace MailCannon\Various;


abstract class DomainManager
{

    protected SqlDataMapper $mapper;


    public function create(DomainObject &$obj)
    {

        $this->mapper->insert($obj);
    }


    public function getById(int $id)
    {

        return $this->mapper->getById($id);
    }


    public function update(DomainObject $obj)
    {

        $this->mapper->update($obj);
    }


    public function delete(DomainObject $obj)
    {

        $this->mapper->deleteById($obj->getId());
    }


    public function fetchAll()
    {

        return $this->mapper->fetchAll();
    }



    public function printAll()
    {

        $char_per_col = 16;
        $columns = ['id' => ""] + $this->mapper->getColumns();

        for($i = 0; $i < count($columns); $i++) // Heading
            printf("___________________");
        printf("\n");
        foreach($columns as $column => $cl)
            printf(" %" . $char_per_col ."s |", $column);
        printf("\n");
        for($i = 0; $i < count($columns); $i++)
            printf("___________________");
        printf("\n");

        foreach($this->fetchAll() as $item) { // Items

            foreach($columns as $column => $c) {

                printf(" %" . $char_per_col ."s |", substr($item[$column], 0, $char_per_col));
            }

            printf("\n");
        }

        printf("\n\n");
    }
}
