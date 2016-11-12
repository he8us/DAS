<?php

namespace CourseBundle\Form;

use CourseBundle\Entity\CourseContent;
use CourseBundle\Entity\Grade;
use CourseBundle\Entity\Lesson;
use CourseBundle\Repository\CourseContentRepository;
use CourseBundle\Repository\GradeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Teacher;
use UserBundle\Repository\UserRepository;

class LessonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'html5'  => true,
                'label'  => 'course.lesson.date',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm',
                'attr'   => [
                    'class' => 'datetimepicker',
                ],
            ])
            ->add('room', TextType::class, [
                'label' => 'course.lesson.room',
            ])
            ->add('content', EntityType::class, [
                'label'         => 'course.lesson.content',
                'class'         => CourseContent::class,
                'choice_label'  => 'name',
                'query_builder' => function (CourseContentRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
            ])
            ->add('teacher', EntityType::class, [
                'label'         => 'course.lesson.teacher',
                'class'         => Teacher::class,
                'choice_label'  => function (Teacher $teacher) {
                    return $teacher->getFirstName() . ' ' . $teacher->getLastName();
                },
                'query_builder' => function (UserRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
            ])
            ->add('grades', EntityType::class, [
                'multiple'      => true,
                'expanded'      => true,
                'label'         => 'course.lesson.grades',
                'class'         => Grade::class,
                'choice_label'  => function (Grade $grade) {
                    return $grade->getGrade();
                },
                'query_builder' => function (GradeRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
            ])
            ->add('remarks', TextareaType::class, [
                'label'    => 'course.lesson.remarks',
                'required' => false,
                'attr'     => [
                    'class' => 'js-wysiwyg',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'coursebundle_lesson';
    }


}
