<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractCrudController extends Controller
{
    /**
     * @var string
     */
    protected $datatable;

    /**
     * @var string
     */
    protected $templateNamespace;


    /**
     * @return Response
     */
    public function indexAction()
    {
        $datatable = $this->get($this->datatable);
        $datatable->buildDatatable();

        return $this->render($this->templateNamespace . 'index.html.twig', [
            'datatable' => $datatable,
        ]);
    }

    /**
     * @return Response
     */
    public function resultsAction()
    {
        $datatable = $this->get($this->datatable);
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

}
