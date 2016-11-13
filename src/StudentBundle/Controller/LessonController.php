<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace StudentBundle\Controller;


use CourseBundle\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends Controller
{

    /**
     * @param Lesson $lesson
     *
     * @return Response
     */
    public function indexAction(Lesson $lesson)
    {

        return $this->render('@Student/Lesson/index.html.twig', [
            'lesson' => $lesson,
            'editable' => false,
            'form' => false
        ]);
    }

    public function registerAction(Lesson $lesson)
    {
        return $this->render('@Student/Lesson/register.html.twig',[
            'lesson' => $lesson
        ]);
    }
}
