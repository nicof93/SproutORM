<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 13/06/2016
 * Time: 0:40
 */

namespace Source;


class DBTableAttribute
{
    private $fieldName;
    private $fieldType;
    private $length;
    private $mayBeNull;
    private $restrictionKey;
    private $defaultValue;

    /**
     * DBTableAttribute constructor.
     * @param $fieldName
     * @param $fieldType
     * @param $mayBeNull
     * @param $restrictionKey
     * @param $defaultValue
     *
     */
    public function __construct($fieldName, $fieldType = 'varchar', $len = 100,
                                $mayBeNull = true, $restrictionKey = null, $defaultValue = '')
    {
        $this->fieldName = $fieldName;
        $this->fieldType = $fieldType;
        $this->length = $len;
        $this->mayBeNull = $mayBeNull;
        $this->restrictionKey = $restrictionKey;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return boolean
     */
    public function isMayBeNull()
    {
        return $this->mayBeNull;
    }

    /**
     * @return null
     */
    public function getRestrictionKey()
    {
        return $this->restrictionKey;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }


    function __toString()
    {
        // TODO: Implement __toString() method.
        return strtoupper($this->fieldName) . ' ' .
                $this->getFieldType() . '[' . $this->length . ']' .
                ($this->mayBeNull) ? ':null' : 'not null ' .
                (!empty($this->defaultValue)) ? '|Default:' . $this->defaultValue . '|' : '';


    }


}