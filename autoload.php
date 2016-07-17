<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 18/06/2016
 * Time: 14:54
 */

require_once (__DIR__) . '/database/Conexion.php';
require_once (__DIR__) . '/database/Mapper.php';

$config = parse_ini_file("/orm/config.ini");

foreach ($config as $key => $configuration){
    define("CONFIG_".$key, $configuration);
}

//connection information[sql engine,dbuser, password[,host=localhost[,db=test]]]
$engine = new \Source\Conexion($config['usser'], $config['password'], $config['database'], $config['dbengine'], $config['host']);

//generate entities class for database tables
$orm = new \Source\Mapper($engine);
$orm->__init();
