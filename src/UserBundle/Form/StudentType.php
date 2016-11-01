<?php

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'user.student.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'user.student.last_name',
            ])
            ->add('username', TextType::class, [
                'label' => 'user.student.username',
            ])
            ->add('email', EmailType::class, [
                'label'    => 'user.student.email',
                'required' => false,
            ])
            ->add('profilePicture', ProfilePictureType::class, [
                "label" => false,
                'required' => false,
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\Student',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_student';
    }


}
