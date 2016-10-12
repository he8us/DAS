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
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function onLateKernelRequest(GetResponseEvent $event)
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    public function onConsoleCommand()
    {
        $this->container->get('gedmo.listener.translatable')
            ->setTranslatableLocale($this->container->get('translator')->getLocale());
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
