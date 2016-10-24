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

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('pretty_role', [$this, 'prettyRoleFilter']),
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
     * @param array $roles
     *
     * @return null|string
     */
    public function prettyRoleFilter(array $roles)
    {
        if (null === $roles) {
            return null;
        }
        return $this->roleService->translate($roles[0]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_extension';
    }
}
