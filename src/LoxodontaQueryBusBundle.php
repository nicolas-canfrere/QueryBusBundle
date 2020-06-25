<?php

namespace Loxodonta\QueryBusBundle;

use Loxodonta\QueryBusBundle\DependencyInjection\Compiler\QueryBusPass;
use Loxodonta\QueryBusBundle\DependencyInjection\LoxodontaQueryBusExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LoxodontaQueryBusBundle
 */
class LoxodontaQueryBusBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new QueryBusPass());
    }
    
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new LoxodontaQueryBusExtension();
        }

        return $this->extension;
    }
}
