<?php

namespace AscensoDigital\ComponentBundle\Tests\EventListener;

use AscensoDigital\ComponentBundle\EventListener\RegisterModificadorSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RegisterModificadorSubscriberTest extends TestCase
{
    public function testPrePersistSetsCreatedAtAndModificadorData()
    {
        $user = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['getId'])
            ->getMock();
        $user->method('getId')->willReturn(42);

        $entity = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['setCreatedAt', 'setModificador', 'setModificadorId', 'setUpdatedAt'])
            ->getMock();

        $entity->expects($this->once())->method('setCreatedAt');
        $entity->expects($this->once())->method('setModificador')->with($user);
        $entity->expects($this->once())->method('setModificadorId')->with(42);
        $entity->expects($this->once())->method('setUpdatedAt');

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $args = $this->createMock(LifecycleEventArgs::class);
        $args->method('getEntity')->willReturn($entity);

        $subscriber = new RegisterModificadorSubscriber($tokenStorage);
        $subscriber->prePersist($args);
    }

    public function testPreUpdateCallsIndex()
    {
        $user = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['getId'])
            ->getMock();
        $user->method('getId')->willReturn(21);

        $entity = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['setModificador', 'setModificadorId', 'setUpdatedAt'])
            ->getMock();

        $entity->expects($this->once())->method('setModificador')->with($user);
        $entity->expects($this->once())->method('setModificadorId')->with(21);
        $entity->expects($this->once())->method('setUpdatedAt');

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $args = $this->createMock(LifecycleEventArgs::class);
        $args->method('getEntity')->willReturn($entity);

        $subscriber = new RegisterModificadorSubscriber($tokenStorage);
        $subscriber->preUpdate($args);
    }

    public function testIndexWithNoTokenOrUser()
    {
        $entity = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['setModificador', 'setModificadorId', 'setUpdatedAt'])
            ->getMock();

        $entity->expects($this->once())->method('setModificador')->with(null);
        $entity->expects($this->once())->method('setModificadorId')->with(null);
        $entity->expects($this->once())->method('setUpdatedAt');

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn(null);

        $args = $this->createMock(LifecycleEventArgs::class);
        $args->method('getEntity')->willReturn($entity);

        $subscriber = new RegisterModificadorSubscriber($tokenStorage);
        $subscriber->preUpdate($args);
    }

    public function testSubscribedEvents()
    {
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $subscriber = new RegisterModificadorSubscriber($tokenStorage);
        $this->assertContains('prePersist', $subscriber->getSubscribedEvents());
        $this->assertContains('preUpdate', $subscriber->getSubscribedEvents());
    }
}
