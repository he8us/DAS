<?php

namespace UserBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;
use UserBundle\Datatables\Columns\RoleColumn;
use UserBundle\Entity\User;

/**
 * Class UserDatatable
 *
 * @package UserBundle\Datatables
 */
class UserDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = [])
    {

        $this->features->set([
            'auto_width'      => true,
            'defer_render'    => false,
            'info'            => true,
            'jquery_ui'       => false,
            'length_change'   => true,
            'ordering'        => true,
            'paging'          => true,
            'processing'      => true,
            'scroll_x'        => false,
            'scroll_y'        => '',
            'searching'       => true,
            'state_save'      => false,
            'delay'           => 0,
            'extensions'      => [],
            'highlight'       => false,
            'highlight_color' => 'red',
        ]);

        $this->ajax->set([
            'url'      => $this->router->generate('user_user_results'),
            'type'     => 'GET',
            'pipeline' => 0,
        ]);

        $this->options->set([
            'display_start'                 => 0,
            'defer_loading'                 => -1,
            'dom'                           => 'lfrtip',
            'length_menu'                   => [10, 25, 50, 100],
            'order_classes'                 => true,
            'order'                         => [[0, 'asc']],
            'order_multi'                   => true,
            'page_length'                   => 10,
            'paging_type'                   => Style::SIMPLE_NUMBERS_PAGINATION,
            'renderer'                      => '',
            'scroll_collapse'               => false,
            'search_delay'                  => 0,
            'state_duration'                => 7200,
            'stripe_classes'                => [],
            'class'                         => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering'          => false,
            'individual_filtering_position' => 'head',
            'use_integration_options'       => true,
            'force_dom'                     => false,
            'row_id'                        => 'id',
        ]);

        $this->columnBuilder
            ->add('id', 'column', [
                'title' => $this->translator->trans('user.id'),
            ])
            ->add('firstName', 'column', [
                'title' => $this->translator->trans('user.first_name'),
            ])
            ->add('lastName', 'column', [
                'title' => $this->translator->trans('user.last_name'),
            ])
            ->add('roles', new RoleColumn(), [
                'title' => $this->translator->trans('user.role'),
            ])
            ->add(null, 'action', [
                'title'   => $this->translator->trans('user.action.title'),
                'actions' => [
                    [
                        'route'            => 'user_user_details',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'label'            => $this->translator->trans('user.action.show'),
                        'icon'             => 'glyphicon glyphicon-eye-open',
                        'attributes'       => [
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans('user.action.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role'  => 'button',
                        ],
                    ],
                    [
                        'route'            => 'user_user_edit',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'label'            => $this->translator->trans('user.action.edit'),
                        'icon'             => 'glyphicon glyphicon-edit',
                        'attributes'       => [
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans('user.action.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role'  => 'button',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_datatable';
    }
}
