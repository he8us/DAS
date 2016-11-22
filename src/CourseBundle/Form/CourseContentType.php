<?php

namespace CourseBundle\Form;

use CourseBundle\Entity\CourseContent;
use CourseBundle\Entity\Grade;
use CourseBundle\Repository\CourseContentRepository;
use CourseBundle\Repository\GradeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Teacher;
use UserBundle\Repository\UserRepository;

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
                    'label'         => 'course.content.grades',
                    'class'         => Grade::class,
                    'choice_label'  => 'grade',
                    'multiple'      => true,
                    'expanded'      => true,
                    'query_builder' => function (GradeRepository $repository) {
                        return $repository->findAllNotDeletedQueryBuilder();
                    },
                ]
            )
            ->add('parent', EntityType::class, [
                'label'         => 'course.content.parent',
                'class'         => CourseContent::class,
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (CourseContentRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
            ])
            ->add('teachers', EntityType::class, [
                'label'         => 'course.content.teachers',
                'class'         => Teacher::class,
                'choice_label'  => function (Teacher $teacher) {
                    return $teacher->getFirstName() . ' ' . $teacher->getLastName();
                },
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function (UserRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
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
