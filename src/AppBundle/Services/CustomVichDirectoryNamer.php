<?php
namespace AppBundle\Services;

use AppBundle\Entity\Post;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class CustomVichDirectoryNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping){
        $name = $object->getCreatedAt()->format('Y-m-d H:i:s');
        $hash = substr(md5($name), 0, 4);
        return $hash;
    }
}