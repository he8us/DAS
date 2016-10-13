<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Twig;

use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Services\RoleService;

/**
 * Class UserExtension
 *
 * @package UserBundle\Twig
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserExtension extends \Twig_Extension
{

    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * UserExtension constructor.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('profile_picture', [$this, 'profilePictureFunction'], [
                'is_safe'           => ['html'],
                'needs_environment' => true,
            ]),
            new \Twig_SimpleFunction('pretty_role', [$this, 'prettyRoleFunction']),
        ];
    }

    /**
     * @param \Twig_Environment $twig
     * @param UserInterface     $user
     * @param string            $class
     *
     * @return string
     */
    public function profilePictureFunction(\Twig_Environment $twig, UserInterface $user, $class = "img-circle")
    {
        return $twig->render('UserBundle:Twig:profile_picture.html.twig', [
            'user'  => $user,
            'class' => $class,
        ]);
    }

    /**
     * @param UserInterface|null $user
     *
     * @return null|string
     */
    public function prettyRoleFunction(UserInterface $user = null)
    {
        if (null === $user) {
            return null;
        }
        return $this->roleService->translate($user->getRoles()[0]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_extension';
    }
}
