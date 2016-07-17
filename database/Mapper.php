<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 12/06/2016
 * Time: 23:59
 */

namespace Source;

use orm\orm;
use util\Generator;

require_once (__DIR__) . '/Conexion.php';
require_once (__DIR__) . '/DBTableEntity.php';
require_once (__DIR__) . '/../util/Generator.php';
require_once (__DIR__) . '/../orm/ORM.php';


class Mapper
{
    private $connection;

    /**
     * Mapper constructor.
     * @param $connection Conexion
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function __init()
    {
        $this->__start();
        foreach ($this->connection->getTables() as $table) {
            $this->generateEntity($table);
        }
    }

    public function __start()
    {
        $this->dm = new ORM($this->connection);
    }

    /**
     * @param $tableName string
     */
    public function generateEntity($table)
    {
        $attrs = $this->connection->getTableAttributes($table);
        $entity = new DBTableEntity($this->connection, $table);
        $entity->setAttributes($attrs);
        
        $this->$table = $entity;
        $this->dm->$table = $entity;

        Generator::__generateFile($entity);
    }


}