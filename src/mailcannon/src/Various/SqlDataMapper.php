<?php

namespace MailCannon\Various;


abstract class SqlDataMapper
{

    private static $instance;

    protected $db;
    protected $select;
    private $where;
    private $order;
    private $limit;
    protected $table;
    private $columns = [];

    public function __construct() 
    {

        $this->db = new Db;

        $this->select       = "SELECT * FROM " . $this->table . " ";
        $this->count_query  = "SELECT COUNT(*) as count FROM " . $this->table . " ";
    }


    public static function instance() {

        if(empty(self::$instance)) {

            self::$instance = new self;
        }

        return self::$instance;
    }


    public function buildQuery()
    {

        return $this->select . $this->where . $this->order . $this->limit;
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
            return $data;

        return false;
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

    public function getByEmail(string $email) {}

}
