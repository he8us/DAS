<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Controller;


use Doctrine\ORM\QueryBuilder;
use Sg\DatatablesBundle\Datatable\Data\DatatableQuery;
use Sg\DatatablesBundle\Datatable\View\DatatableViewInterface;
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

        $query = $this->getQueryFromDatatable($datatable);

        return $query->getResponse();
    }


    /**
     * @param DatatableViewInterface $datatable
     *
     * @return DatatableQuery
     */
    public function getQueryFromDatatable(DatatableViewInterface $datatable)
    {
        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        $query->addWhereAll(function(QueryBuilder $qb){
            $rootAliases = $qb->getRootAliases();
            $qb->andWhere($rootAliases[0].'.deletedAt IS NULL');
        });

        return $query;
    }


}
