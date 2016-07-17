<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 13/06/2016
 * Time: 0:15
 */

namespace Source;


class DBTableEntity
{
    private $name;
    private $attributes;
    private $connection;

    /**
     * DBTableEntity constructor.
     * @param $connection Conexion
     */
    public function __construct($connection, $name)
    {
        $this->connection = $connection;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Insert a register on database table
     * @param $entity DBTableEntity
     * @return bool
     */
    public function insert($entity){

    }

    /**
     * Update register in database
     * @param $entity DBTableEntity
     * @return bool
     */
    public function update($entity){

    }

    /**
     * Generate a list of entities with table data
     * @param $entity DBTableEntity
     * @return array
     */
    public function getAll($entity){

    }

}