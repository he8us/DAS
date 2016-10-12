<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

/**
 * Class UserController
 *
 * @package UserBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserController extends Controller
{
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $datatable = $this->get("user.datatable.users");
        $datatable->buildDatatable();

        return $this->render('UserBundle:User:list.html.twig', [
            'datatable' => $datatable,
        ]);
    }


    public function newAction()
    {
        return $this->render('UserBundle:User:new.html.twig');
    }

    public function resultsAction()
    {

        $datatable = $this->get('user.datatable.users');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();

    }

    /**
     * @param string $confirmed
     *
     * @return Response
     */
    public function deleteAccountAction($confirmed = "")
    {
        if (empty($confirmed)) {
            return $this->render("UserBundle:Profile:delete.html.twig");
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->deleteUser($this->getUser());
        return $this->redirectToRoute('page_homepage');
    }

    public function profileShowAction()
    {

    }
}
