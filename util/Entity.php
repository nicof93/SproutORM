<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 20/06/2016
 * Time: 0:45
 */

namespace util;


class Entity
{
    private $dbname;

    /**
     * Entity constructor.
     * @param $dbname
     */
    public function __construct($dbname)
    {
        $this->dbname = $dbname;
    }


    /**
     * @return mixed
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * @param mixed $dbname
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }


}