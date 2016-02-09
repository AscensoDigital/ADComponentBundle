<?php

namespace AscensoDigital\ComponentBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of ObjectToCampoTransformer
 *
 * @author claudio
 */
class ObjectToCampoTransformer implements DataTransformerInterface
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
     * @var string
     */
    private $campo;

    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     * @param string $objectClass
     */
    public function __construct(ObjectManager $om, $objectClass, $campo)
    {
        $this->om = $om;
        $this->objectClass= $objectClass;
        $this->campo=$campo;
    }

    /**
     * Transforms an object to a string (campo).
     *
     * @param  Object|null $object
     * @return string
     */
    public function transform($object)
    {
        if (null === $object) {
            return "";
        }

        return call_user_func(array($object, 'get'.ucfirst($this->campo)));
    }

    /**
     * Transforms a string (campo) to an object.
     *
     * @param  string $id
     *
     * @return Object|null
     *
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($valor)
    {
        if (!$valor) {
            return null;
        }

        $object = $this->om->getRepository($this->objectClass)->findOneBy(array($this->campo => $valor));

        if (null === $object) {
            throw new TransformationFailedException(sprintf(
                'Object class %s con '.$this->campo.' "%s" no existe!',
                $this->objectClass, $valor
            ));
        }

        return $object;
    }
}
