<?php
/**
 * Created by Nicolás Diaz.
 * User: niko_
 * Date: 13/06/2016
 * Time: 1:39
 */

namespace util;


use Source\DBTableEntity;

class Generator
{
    /**
     * @param $entity DBTableEntity
     */
    public static function __generateFile($entity)
    {
        $pencil = new Pencil();
        $name = ucfirst($entity->getName());

        if (!is_dir("../Entities")){
            mkdir("../Entities");
        }

            $handle = fopen("../Entities/".$name.'.php', 'w');
        fwrite($handle,"<?php\nrequire_once (__DIR__).'\..\util\Entity.php';\n\nclass ".$name." extends \util\Entity \n{\n\n");

        foreach ($entity->getAttributes() as $key => $attr){
            fwrite($handle,"    private $".$key.";\n");
        }

        fwrite($handle,$pencil->generateConstructor($name));

        foreach ($entity->getAttributes() as $key => $attr){
            fwrite($handle,$pencil->generateGetter($key, $attr->getFieldType())."\n");
            fwrite($handle,$pencil->generateSetter($key, $attr->getFieldType())."\n");
        }

        fwrite($handle,"\n}");
        fclose($handle);
    }
}

class Pencil{

    private $containername;

    /**
     * Pencil constructor.
     * @param $containername
     */
    public function __construct()
    {
        $this->containername = "Entities";
    }

    public function generateConstructor($name)
    {
        return "\n    function __construct()\n    {\n        parent::__construct('".$name."');\n    }\n\n";
    }

    public function generateGetter($name)
    {
        return "\n    public function get".ucfirst($name)."()\n    {\n        return $"."this->".$name.";\n    }";
    }

    public function generateSetter($name)
    {
        return "\n    public function set".ucfirst($name)."($".$name.")\n    {\n        $"."this->".$name."= $".$name.";\n    }";
    }


}