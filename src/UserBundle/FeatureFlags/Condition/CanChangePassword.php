<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\FeatureFlags\Condition;

use DZunke\FeatureFlagsBundle\Context;
use DZunke\FeatureFlagsBundle\Toggle\Conditions\ConditionInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

/**
 * Class CanChangePassword
 *
 * @package UserBundle\FeatureFlags\Condition
 *
 * @author  Cedric Michaux <cedric@he8us.be>
 */
class CanChangePassword implements ConditionInterface
{

    /**
     * @var Context
     */
    private $context;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authChecker;

    /**
     * CanChangePassword constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authChecker = $authorizationChecker;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'can_change_password';
    }

    /**
     * @param      $config
     * @param null $argument
     *
     * @return bool
     */
    public function validate($config, $argument = null)
    {
        if (null === $this->authChecker) {
            return false;
        }

        try {
            return !$this->authChecker->isGranted('ROLE_STUDENT');
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return true;
        }
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }
}
