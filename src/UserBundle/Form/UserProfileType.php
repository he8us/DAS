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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfileType extends AbstractType
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
            ->add('profilePicture',
                ProfilePictureType::class,
                [
                    'label'    => false,
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
            );


    }



    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_user_edit';
    }
}
