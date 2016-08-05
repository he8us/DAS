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
 * Class CanDeleteAccount
 * @package UserBundle\FeatureFlags\Condition
 * @author  Cedric Michaux <cedric@he8us.be>
 */
class CanDeleteAccount extends CanChangePassword
{
}
