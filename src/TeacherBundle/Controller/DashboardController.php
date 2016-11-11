<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace TeacherBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('TeacherBundle:Dashboard:index.html.twig', [
            'user' => $this->getUser(),
            'eventsEndpoints' => 'teacher_calendar_events'
        ]);
    }

}
