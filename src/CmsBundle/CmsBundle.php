<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CmsBundle;

use CmsBundle\DependencyInjection\Compiler\MenuPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CmsBundle
 *
 * @package CmsBundle
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CmsBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MenuPass());
    }
}
