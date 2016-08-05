<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CMSBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MenuPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('cms.menu_chain')) {
            return;
        }

        $definition = $container->findDefinition('cms.menu_chain');

        $taggedServices = $container->findTaggedServiceIds('cms.menu.item');


        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addMenuItems', array(new Reference($id)));
        }

    }
}
