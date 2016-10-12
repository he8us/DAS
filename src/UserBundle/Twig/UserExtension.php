<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Twig;


use Symfony\Component\Security\Core\User\UserInterface;


class UserExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('profile_picture', [$this, 'profilePictureFunction'], [
                'is_safe'           => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function profilePictureFunction(\Twig_Environment $twig, UserInterface $user, $class = "img-circle")
    {
        return $twig->render('UserBundle:Twig:profile_picture.html.twig', [
            'user'  => $user,
            'class' => $class,
        ]);
    }

    public function getName()
    {
        return 'user_extension';
    }
}
