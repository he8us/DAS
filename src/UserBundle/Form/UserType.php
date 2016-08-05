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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

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
                    "label" => "form.user.last_name",
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    "label" => "form.user.first_name",
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => "form.user.username"
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'form.user.password.should_match',
                    'first_options'  => ['label' => 'form.user.password'],
                    'second_options' => ['label' => 'form.user.password.repeat'],
                ]
            )

            ->add(
                'email',
                RepeatedType::class,
                [
                    'type' => EmailType::class,
                    'invalid_message' => 'form.user.email.should_match',
                    'first_options'=> ['label' => 'form.user.email'],
                    'second_options'=> ['label' => 'form.user.email.repeat']

                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'form.user.phone'
                ]
            )

            ->add(
                'profilePicture',
                ProfilePictureType::class,
                [
                    "label" => false,
                    'required' => false
                ]
            );
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
