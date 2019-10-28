<?php

namespace AscensoDigital\ComponentBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ObjectToIdTransformer
 *
 * @author claudio
 */
class ObjectToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     *
     * @var string
     */
    private $objectClass;

    /**
     * @var boolean
     */
    private $sinDigito;

    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     * @param string $objectClass
     */
    public function __construct(ObjectManager $om, $objectClass, $sinDigito=false)
    {
        $this->om = $om;
        $this->objectClass= $objectClass;
        $this->sinDigito=$sinDigito;
    }

    /**
     * Transforms an object to a string (id).
     *
     * @param  Object|null $object
     * @return string
     */
    public function transform($object)
    {
        if (null === $object) {
            return "";
        }

        return is_object($object->getId()) ? $object->getId()->getId() : $object->getId();
    }

    /**
     * Transforms a string (id) to an object.
     *
     * @param  string $id
     *
     * @return Object|null
     *
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
        if($this->sinDigito) {
            $id=trim(substr($id,0,-1));
        }
        $id=intval($id);
        $object = $this->om
            ->getRepository($this->objectClass)
            ->find($id);

        if (null === $object) {
            throw new TransformationFailedException(sprintf(
                'Object class %s con id "%s" no existe!',
                $this->objectClass, $id
            ));
        }

        return $object;
    }
}
