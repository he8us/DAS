<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class DoctrineExtensionListener
 *
 * @package CoreBundle\Listener
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onLateKernelRequest()
    {
        $this->initializeTranslatable();
    }

    private function initializeTranslatable()
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($this->container->get('translator')->getLocale());
    }

    public function onConsoleCommand()
    {
        $this->initializeTranslatable();
    }

    public function onKernelRequest()
    {
        $token = $this->container->get('security.token_storage')->getToken();

        if ($this->isUserAuthenticated($token)) {
            $this->initiaiizeLoggable($token);
            $this->initializeBlameable($token);
        }
    }

    /**
     * @param TokenInterface $token
     *
     * @return bool
     */
    private function isUserAuthenticated(TokenInterface $token):bool
    {
        $authorizationChecker = $this->container->get('security.authorization_checker');
        return null !== $token && $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }

    /**
     * @param TokenInterface $token
     */
    private function initiaiizeLoggable(TokenInterface $token)
    {
        $loggable = $this->container->get('gedmo.listener.loggable');
        $loggable->setUsername($token->getUser());
    }

    /**
     * @param TokenInterface $token
     */
    private function initializeBlameable(TokenInterface $token)
    {
        $blameable = $this->container->get('gedmo.listener.blameable');
        $blameable->setUserValue($token->getUser());
    }
}
