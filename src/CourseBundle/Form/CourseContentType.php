<?php

namespace CourseBundle\Form;

use CourseBundle\Entity\CourseContent;
use CourseBundle\Entity\Grade;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Teacher;

class CourseContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'course.content.name',
            ])
            ->add('grades', EntityType::class,
                [
                    'label'        => 'course.content.grades',
                    'class'        => Grade::class,
                    'choice_label' => 'grade',
                    'multiple'     => true,
                    'expanded'     => true,
                ]
            )
            ->add('parent', EntityType::class, [
                'label'        => 'course.content.parent',
                'class'        => CourseContent::class,
                'choice_label' => 'name',
                'required'     => false,
            ])
            ->add('teachers', EntityType::class, [
                'label'        => 'course.content.teachers',
                'class'        => Teacher::class,
                'choice_label' => function (Teacher $teacher) {
                    return $teacher->getFirstName() . ' ' . $teacher->getLastName();
                },
                'multiple'     => true,
                'expanded'     => true,
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
