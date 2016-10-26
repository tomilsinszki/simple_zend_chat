<?php

namespace Chat\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Chat\Controller\ChatController;

class ChatControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName, array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new ChatController($entityManager);
    }
}
