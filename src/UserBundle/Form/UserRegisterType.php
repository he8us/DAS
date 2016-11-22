<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

/**
 * Class UserRegisterType
 *
 * @package UserBundle\Form
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserRegisterType extends UserType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildForm($builder, $options);

        $builder
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'user.password.should_match',
                    'first_options'   => ['label' => 'user.password'],
                    'second_options'  => ['label' => 'user.password.repeat'],
                ]
            )
            ->add(
                'email',
                RepeatedType::class,
                [
                    'type'            => EmailType::class,
                    'invalid_message' => 'user.email.should_match',
                    'first_options'   => ['label' => 'user.email'],
                    'second_options'  => ['label' => 'user.email.repeat'],

                ]
            );

    }


    /**
     * {@inheritdoc}
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
            'validation_groups' => ['registration'],
        ]);
    }
}
