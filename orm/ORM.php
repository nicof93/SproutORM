<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 18/06/2016
 * Time: 15:06
 */

namespace orm;


use Source\Conexion;
use Source\DBTableEntity;
use util\Entity;
use util\Logger;

class ORM
{
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var Logger
     */
    private $DEBUGGER;
    /**
     * @var Conexion
     */
    private $connection;
    /**
     * @var \PDO
     */
    private $db;

    /**
     * path for entity classes
     * @var string
     */
    private $entity_folder;

    /**
     * orm constructor.
     * @param  $connection Conexion
     */
    public function __construct(Conexion $connection)
    {
        $this->logger = new Logger();
        $this->DEBUGGER = new Logger("db_debug");
        $this->connection = $connection;
        $this->db = $connection->getSource();
        $this->entity_folder = constant("CONFIG_entity_folder");
    }

    /**
     * @param Entity|array $entity_instance
     * @return int|false
     */
    public function persist($entity_instance)
    {
        //transaction.- start.
        $this->connection->getSource()->beginTransaction();

        //try to persist object and commit for confirm changes
        try{

            $this->connection->getSource()->commit();
        }catch (\Exception $ex){
            
            //revert transaction
            $this->connection->getSource()->rollBack();
        }

        $type = gettype($entity_instance);

        $dbtable = $entity_instance->getDbname();
        $this->logger->add("orm", $dbtable);

        $base = "INSERT INTO %s SET %s;";
        $args = array();

        foreach ($this->connection->getTableAttributes($dbtable) as $index => $attr){
            $get_method = "get".ucfirst($index);
            if (!empty($entity_instance->$get_method())){
                $args[] = sprintf("%s = '%s'", $index, $entity_instance->$get_method());
            }
        }

        $aux = implode(',', $args);
        $sql = sprintf($base, $dbtable,$aux );
        $this->logger->add("DATABASE", "persist into $dbtable");
        $this->DEBUGGER->add($dbtable, $sql);

        $query = $this->db->query($sql);
        $result = !empty($query) ? $query->execute() : 0;

        return $result > 0 ? $this->db->lastInsertId() : false;
        
    }

    public function getAll($entity_name)
    {
        $sql = sprintf("SELECT * FROM %s", $entity_name);
        $query = $this->db->query($sql);
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        $object = $this->arrayToEntity($result, $entity_name);

        return $object;
    }

    /**
     * @param $entity_name
     * @param $conditions array
     * @return array|Entity
     */
    public function getBy($entity_name, $conditions)
    {
        $sql = sprintf("SELECT * FROM %s", $entity_name);
        $query = $this->db->query($sql);
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        $object = $this->arrayToEntity($result, $entity_name);

        return $object;
    }

    /**
     * Convert query's result in Entity array
     * @param $queryResult array
     * @param $entity_name string
     * @return array| Entity
     */
    protected function arrayToEntity($queryResult, $entity_name)
    {
        $entityArray = array();
        $aux = ucfirst($entity_name);

        require_once sprintf("/../Entities/%s.php", $aux);

        foreach ($queryResult as $item) {
            $entity = new $aux();
            foreach ($item as $key => $value){
                $setter = sprintf("set%s", ucfirst($key));
                $entity->$setter($value);
            }
            $entityArray[] = $entity;
        }

        return $entityArray;
    }
}