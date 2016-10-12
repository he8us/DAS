<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMSBundle\Form;

use CMSBundle\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 *
 * @package CMSBundle\Form
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    "label" => "form.cms.page.title",
                ]
            )
            ->add(
                'body',
                TextType::class, [
                    "label" => "form.cms.page.body",
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
