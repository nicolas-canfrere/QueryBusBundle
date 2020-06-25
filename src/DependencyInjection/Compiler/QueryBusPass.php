<?php

namespace Loxodonta\QueryBusBundle\DependencyInjection\Compiler;

use Loxodonta\QueryBus\QueryBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class QueryBusPass
 */
class QueryBusPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(QueryBus::class)) {
            return;
        }

        $definition = $container->findDefinition(QueryBus::class);

        $taggedServices = $container->findTaggedServiceIds('loxodonta.query_bus.handler');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('registerHandler', [new Reference($id)]);
        }

        if ($container->hasParameter('loxodonta.query_bus.middlewares')) {
            $middlewareIds = $container->getParameter('loxodonta.query_bus.middlewares');
            $container->getParameterBag()->remove('loxodonta.query_bus.middlewares');
            foreach ($middlewareIds as $id) {
                if ($container->has($id)) {
                    $definition->addMethodCall('registerMiddleware', [new Reference($id)]);
                }
            }
        }
    }

}
