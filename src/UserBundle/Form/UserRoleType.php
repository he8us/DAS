<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'role',
                ChoiceType::class,
                [
                    "label"   => "user.role",
                    "choices" => [
                        'user.role.coordinator' => 'coordinator',
                        'user.role.course_titular' => 'course_titular',
                        'user.role.parent' => 'student_parent',
                        //'user.role.student' => 'student',
                        'user.role.teacher' => 'teacher',
                        'user.role.titular' => 'titular'
                    ],
                    "required" => true
                ]
            );
    }
}
