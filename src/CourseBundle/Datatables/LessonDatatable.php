<?php

namespace CourseBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class LessonDatatable
 *
 * @package CourseBundle\Datatables
 */
class LessonDatatable extends AbstractDatatableView
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
            'url'      => $this->router->generate('course_lesson_results'),
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
            'paging_type'                   => Style::FULL_NUMBERS_PAGINATION,
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
                'title' => $this->translator->trans('course.lesson.id'),
            ])
            ->add('startDate', 'datetime', [
                'title' => $this->translator->trans('course.lesson.start_date'),
            ])
            ->add('endDate', 'datetime', [
                'title' => $this->translator->trans('course.lesson.end_date'),
            ])
            ->add('room', 'column', [
                'title' => $this->translator->trans('course.lesson.room'),
            ])
            ->add('remarks', 'column', [
                'title' => $this->translator->trans('course.lesson.remarks'),
                'class' => 'remarks',
                'render' => 'render_remarks_column'
            ])
            ->add(null, 'action', [
                'title'   => $this->translator->trans('course.datatable.actions.title'),
                'actions' => [
                    [
                        'route'            => 'course_lesson_show',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'label'            => $this->translator->trans('course.datatable.actions.show'),
                        'icon'             => 'glyphicon glyphicon-eye-open',
                        'attributes'       => [
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans('course.datatable.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role'  => 'button',
                        ],
                    ],
                    [
                        'route'            => 'course_lesson_edit',
                        'route_parameters' => [
                            'id' => 'id',
                        ],
                        'label'            => $this->translator->trans('course.datatable.actions.edit'),
                        'icon'             => 'glyphicon glyphicon-edit',
                        'attributes'       => [
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans('course.datatable.actions.edit'),
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
        return 'CourseBundle\Entity\Lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'course_lesson_datatable';
    }
}
