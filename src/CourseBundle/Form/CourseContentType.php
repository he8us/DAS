<?php

namespace CourseBundle\Form;

use CourseBundle\Entity\CourseContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('section',
                TextType::class,
                [
                    'label' => 'course.content.section',
                ]
            )
            ->add('parent', TextType::class, [
                'label' => 'course.content.parent',
            ])
            ->add('teachers', TextType::class, [
                'label' => 'course.content.teachers',
            ])
            ->add('grades', TextType::class, [
                'label' => 'course.content.grades',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseContent::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'coursebundle_coursecontent';
    }

}
