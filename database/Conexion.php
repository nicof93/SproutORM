<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 12/06/2016
 * Time: 22:55
 */

namespace Source;

require_once (__DIR__) . '/DBTableAttribute.php';
require_once (__DIR__) . '/../util/Logger.php';

use Source\DBTableAttribute;
use util\Logger;

class Conexion
{

    private $sql_engine;
    private $DBUser;
    private $password;
    private $database;

    private $source;
    private $logger;
    private $DEBUGGER;

    /**
     * Connection constructor.
     * @param $sql_engine
     * @param $DBUser
     * @param $password
     * @param $database
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function __construct($DBUser, $password, $database = 'test', $sql_engine = 'mysql',$host = 'localhost')
    {
        $this->sql_engine = $sql_engine;
        $this->DBUser = $DBUser;
        $this->password = $password;
        $this->database = $database;
        $this->logger = new Logger('system', true);
        $this->DEBUGGER = new Logger("db_debug");

        switch ($sql_engine) {
            case 'mysql':
                $dsn = "mysql:host={$host};dbname={$database}";
                try {
                    $this->source = new \PDO($dsn, $DBUser, $password);
                } catch (\PDOException $ex) {
                    $this->logger->add("FATAL_CONNECTION_ERROR", $ex->getMessage());
                    $this->DEBUGGER->add("StackTrace", $ex->getTraceAsString());
                    die("SERVER_UNAVAILABLE");
                }

                break;
            case 'sql_server':
                throw new \Exception("Not implement method");
                break;
            case 'oracle':
                throw new \Exception("Not implement method");
                break;
            case 'mongo':
                throw new \Exception("Not implement method");
                break;
            default:
                throw new \InvalidArgumentException("Database not supported");
        }
    }

    /**
     * @return \PDO
     */
    public function getSource()
    {
        return $this->source;
    }

    public function getTables()
    {
        $tables = $this->getSource()->query("SHOW TABLES")->fetchAll();
        $tablesList = array();

        $index = "Tables_in_" . $this->database;

        foreach ($tables as $table) {
            $tablesList[] = $table[$index];
        }
        return $tablesList;
    }

    public function getTableAttributes($tableName)
    {
        $describe = "DESCRIBE " . $tableName;
        $this->DEBUGGER->add("connection", "getTableAttributes: " . $describe);

        $query = $this->getSource()->query($describe);


        $data = !empty($query) ? $query->fetchAll(\PDO::FETCH_ASSOC) : array();

        $properties = array();

        foreach ($data as $attrib) {
            $aux = $this->analise($attrib['Type']);

            $dbattrib = new DBTableAttribute(
                $attrib['Field'],
                $aux['DBType'],
                $aux['length'],
                ($attrib['Null'] == 'YES' ? true : false),
                $attrib['Key'],
                $attrib['Default']
            );

            $properties[strtolower($attrib['Field'])] = $dbattrib;
        }

        return $properties;
    }

    /**
     * @param $data string
     * @return array
     */
    private function analise($data)
    {
        $data = str_replace(')', '', $data);
        $pieces = explode('(', $data);

        $this->logger->add("ANALISE", $data . ' == ' . json_encode($pieces));

        return array(
            "DBType" => $pieces[0],
            "length" => isset($pieces[1]) ? $pieces[1] : 0
        );
    }

    /**
     * @return string
     */
    public function getSqlEngine()
    {
        return $this->sql_engine;
    }

    /**
     * @param string $sql_engine
     */
    public function setSqlEngine($sql_engine)
    {
        $this->sql_engine = $sql_engine;
    }

    /**
     * @return mixed
     */
    public function getDBUser()
    {
        return $this->DBUser;
    }

    /**
     * @param mixed $DBUser
     */
    public function setDBUser($DBUser)
    {
        $this->DBUser = $DBUser;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }
}