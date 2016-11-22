<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

/**
 * Class UserType
 *
 * @package UserBundle\Form
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'lastName',
                TextType::class,
                [
                    "label" => "user.last_name",
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    "label" => "user.first_name",
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "user.username",
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label'    => 'user.password',
                    'required' => false,
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'user.email',
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'user.phone',
                ]
            )
            ->add(
                'profilePicture',
                ProfilePictureType::class,
                [
                    "label"    => false,
                    'required' => false,
                ]
            );
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => ['edition'],
        ]);
    }
}
