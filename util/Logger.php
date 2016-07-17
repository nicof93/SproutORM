<?php
/**
 * Created by Nicolas.
 * User: niko_
 * Date: 11/06/2016
 * Time: 18:31
 */

namespace util;


class Logger
{
    private $log_name;
    /**
     * Logger constructor.
     * @param $clearBeforeStart bool Is is true, delete file before start to work
     */
    public function __construct($logname = "system", $clearBeforeStart = false)
    {
        $logname = '../logs/'.$logname.'.log';
        if ($clearBeforeStart && file_exists($logname)){
            unlink($logname);
        }
        $this->log_name = $logname;
    }

    public function add($key, $record){

        $picker = new \DateTime();

        $handle = fopen($this->log_name, 'a');
        fwrite($handle, $picker->format("d-m-Y H:i:s") .' ['. strtoupper($key) .'] ' . $record."\n");
        fclose($handle);
    }
}