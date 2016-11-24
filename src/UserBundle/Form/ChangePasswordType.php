<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'user.old_password',
            ])
            ->add('newPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => 'user.password.should_match',
                'first_options'   => ['label' => 'user.password'],
                'second_options'  => ['label' => 'user.password.repeat'],
            ]);

    }

    /**
     * @return string
     */
    public
    function getBlockPrefix()
    {
        return 'user_profile_change_password';
    }

}
