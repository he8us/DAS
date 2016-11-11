<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace TeacherBundle\Controller;


use CourseBundle\Entity\Lesson;
use CourseBundle\Service\LessonService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TeacherBundle\Form\LessonRemarkType;

class LessonController extends Controller
{
    /**
     * @param Request $request
     * @param Lesson  $lesson
     *
     * @return Response
     */
    public function indexAction(Request $request, Lesson $lesson)
    {
        $form = $this->createForm(LessonRemarkType::class, $lesson);

        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid() ){
            $this->getLessonService()->save($lesson);
        }

        return $this->render('TeacherBundle:Lesson:index.html.twig', [
            'lesson' => $lesson,
            'editable' => $lesson->getDate() > new \DateTime(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @return LessonService
     */
    private function getLessonService()
    {
        return $this->get('course.services.lesson');
    }
}
