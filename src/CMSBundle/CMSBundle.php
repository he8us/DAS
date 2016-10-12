<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMSBundle;

use CMSBundle\DependencyInjection\Compiler\MenuPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CMSBundle
 *
 * @package CMSBundle
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CMSBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MenuPass());
    }
}
