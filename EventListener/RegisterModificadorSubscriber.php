<?php

namespace AscensoDigital\ComponentBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of RegisterModificadorSubscriber
 *
 * @author claudio
 */
class RegisterModificadorSubscriber implements EventSubscriber {
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents()
    {
        return array('prePersist', 'preUpdate');
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if(method_exists($entity, 'setCreatedAt')){
            call_user_func(array($entity, 'setCreatedAt'), new \DateTime());
        }
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $usuario= is_null($this->tokenStorage->getToken()) || is_string($this->tokenStorage->getToken()) ? null : $this->tokenStorage->getToken()->getUser();
        if(method_exists($entity, 'setModificador')) {
            call_user_func(array($entity, 'setModificador'), is_object($usuario) ? $usuario : null);
        }
        if(method_exists($entity, 'setModificadorId')){
            call_user_func(array($entity, 'setModificadorId'), is_null($usuario) || !method_exists($usuario, 'getId') ? null : $usuario->getId());
        }
        if(method_exists($entity, 'setUpdatedAt')) {
            call_user_func(array($entity, 'setUpdatedAt'), new \DateTime());
        }
    }
}
