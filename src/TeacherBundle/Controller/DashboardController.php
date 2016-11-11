<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace TeacherBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    public function indexAction()
    {

        $teacher = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('TeacherBundle:Dashboard:index.html.twig', [
            "teacher" => $teacher,
        ]);
    }

}
