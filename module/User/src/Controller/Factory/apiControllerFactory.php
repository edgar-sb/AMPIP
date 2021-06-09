<?php

//namespace User\Controller;
namespace User\Controller\Factory;


use User\Controller\apiController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

/**
 * This is the factory for apiController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class apiControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $transport = new Smtp();
        $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
        // Instantiate the controller and inject dependencies
        return new apiController($entityManager, $transport);
    }
}