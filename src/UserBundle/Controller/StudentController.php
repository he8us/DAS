<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StudentController
 * @package UserBundle\Controller
 * @author  Cedric Michaux <cedric@he8us.be>
 */
class StudentController extends Controller
{


    const ROLE_STUDENT = 'ROLE_STUDENT';

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $datatable = $this->get("user.datatable.students");
        $datatable->buildDatatable();

        return $this->render('UserBundle:Student:list.html.twig', [
            'datatable' => $datatable
        ]);
    }



    public function newAction()
    {
        return $this->render('UserBundle:Student:new.html.twig');
    }

    public function resultsAction()
    {

        $datatable = $this->get('user.datatable.students');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();

    }

    public function importAction()
    {
        
    }


}
