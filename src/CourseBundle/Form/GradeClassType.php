<?php

namespace CourseBundle\Form;

use CourseBundle\Entity\Grade;
use CourseBundle\Entity\GradeClass;
use CourseBundle\Repository\GradeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Titular;
use UserBundle\Repository\UserRepository;

class GradeClassType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('section', TextType::class, [
                'label' => 'course.gradeclass.section',
            ])
            ->add('grade', EntityType::class, [
                'class'         => Grade::class,
                'choice_label'  => 'grade',
                'query_builder' => function (GradeRepository $repository) {
                    return $repository->findAllNotDeletedQueryBuilder();
                },
            ])
            ->add('titular', EntityType::class, [
                'class'         => Titular::class,
                'choice_label'  => function (Titular $titular) {
                    return $titular->getFirstName() . ' ' . $titular->getLastName();
                },
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
            'data_class' => GradeClass::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'coursebundle_gradeclass';
    }


}
