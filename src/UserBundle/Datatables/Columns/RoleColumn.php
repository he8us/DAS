<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Datatables\Columns;


use Sg\DatatablesBundle\Datatable\Column\Column;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleColumn extends Column
{


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->remove('default_content');

        $resolver->setDefaults(array(
            'render' => 'render_role',

        ));

        return $this;
    }

    public function getAlias()
    {
        return "role";
    }
}
