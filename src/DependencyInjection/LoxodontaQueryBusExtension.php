<?php

namespace Loxodonta\QueryBusBundle\DependencyInjection;

use Loxodonta\QueryBus\Signature\QueryBusHandlerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class LoxodontaQueryBusExtension
 */
class LoxodontaQueryBusExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(QueryBusHandlerInterface::class)
            ->addTag('loxodonta.query_bus.handler');
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        if (!empty($config['middlewares'])) {
            $middlewares = [];
            foreach ($config['middlewares'] as $middleware) {
                if (class_exists($middleware)) {
                    $middlewares[] = $middleware;
                }
            }
            $container->setParameter('loxodonta.query_bus.middlewares', $middlewares);
        }
    }

    public function getAlias()
    {
        return 'loxodonta_query_bus';
    }
}
