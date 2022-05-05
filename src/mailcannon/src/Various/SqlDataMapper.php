<?php

namespace MailCannon\Various;


abstract class SqlDataMapper
{

    private static $instance;

    protected   Db          $db;
    protected   string      $select;
    private     string      $where;
    private     string      $order;
    private     string      $limit;
    protected   string      $table;
    protected   array       $columns = [];

    public function __construct() 
    {

        $this->db = new Db;

        $this->select       = "SELECT * FROM " . $this->table . " ";
        $this->count_query  = "SELECT COUNT(*) as count FROM " . $this->table . " ";
        $this->order        = "";
        $this->limit        = "";
        $this->where        = "";
    }


    public static function instance() {

        if(empty(self::$instance)) {

            self::$instance = new self;
        }

        return self::$instance;
    }


    public function getColumns() : array { return $this->columns; }


    public abstract function prepareObj(array $data) : DomainObject;


    public function buildQuery()
    {

        return $this->select . $this->where . $this->order . $this->limit;
    }


    public function insert(DomainObject &$obj)
    {

        $sql = "INSERT INTO " . $this->table . "
                SET ";

        $i = 1;
        foreach($this->columns as $column => $function) {

            $sql .= $column . " = '" . $obj->$function() . "'";
            if($i != count($this->columns))
                $sql .= ", ";
            else
                $sql .= " ";

            $i++;
        }
        
        $this->db->query($sql)->execute();
        $obj = $this->getById($this->db->lastId());
    }


    public function update(DomainObject $obj)
    {

        $sql = "UPDATE " . $this->table . "
                SET ";

        $i = 1;
        foreach($this->columns as $column => $function) {

            $sql .= $column . " = '" . $obj->$function() . "'";
            if($i != count($this->columns))
                $sql .= ", ";
            else
                $sql .= " ";

            $i++;
        }

        $sql .= "WHERE id = " . $obj->getId();
        $this->db->query($sql)->execute();
    }


    public function where($stmt) {

        if(empty($this->where)) $this->where = " WHERE " . $stmt . " ";

        else $this->where .= " AND " . $stmt . " ";
    }

    
    public function order($column, $dir = "DESC") {

        $this->order = " ORDER BY " . $column . " " . $dir . " ";
    }

    
    public function limit($limit, $offset = 0) {


        if(empty($offset))
            $this->limit = " LIMIT " . $limit . " ";

        else
            $this->limit = " LIMIT " . $offset . ", " . $limit . " ";
    }


    public function deleteById(int $id)
    {

        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $id;

        if($this->db->query($sql)->execute())
            return true;

        return false;

    }

    
    public function getById(int $id)
    {

        $this->where("id = " . $id);

        $sql = $this->buildQuery();

        if($data = $this->db->query($sql)->single())
            return $this->prepareObj($data);
    }


    public function next()
    {

        if($data = $this->db->query($sql)->next())
            return $this->prepareObj($data);
    }

    public function count() : int
    {
        
        return $this->db->query($this->count_query . $this->where)->single()['count'];
    }


    public function fetchAll() 
    {

        $sql = $this->buildQuery();
        return $this->db->query($sql)->resultSet();
    }


    public function fetchFirst()
    {

        $sql = $this->buildQuery();
        if($first = $this->db->query($sql)->single())
            return $this->prepareObj($first);
    }


    public function fetchNext()
    {

        if($next = $this->db->next())
            return $this->prepareObj($next);
    }


    public function getByEmail(string $email) {}

}
