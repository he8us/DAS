<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace StudentBundle\Controller;


use CourseBundle\Entity\Lesson;
use StudentBundle\Service\StudentRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

        $registration = $this->getStudentRegistrationService()->findByStudentAndLesson($this->getUser(), $lesson);

        return $this->render('@Student/Lesson/index.html.twig', [
            'lesson'       => $lesson,
            'editable'     => false,
            'form'         => false,
            'registration' => $registration,
        ]);
    }

    /**
     * @return StudentRegistrationService
     */
    private function getStudentRegistrationService()
    {
        return $this->get('student.service.registration');
    }

    /**
     * @param Lesson $lesson
     * @param string $confirm
     *
     * @return RedirectResponse|Response
     */
    public function registerAction(Lesson $lesson, $confirm = 'no')
    {
        if ($confirm === 'yes') {
            $this->getStudentRegistrationService()->register($lesson, $this->getUser());
            return $this->redirectToRoute('student_lesson_details', [
                'id' => $lesson->getId(),
            ]);
        }

        return $this->render('@Student/Lesson/register.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * @param Lesson $lesson
     * @param string $confirm
     *
     * @return RedirectResponse|Response
     */
    public function unregisterAction(Lesson $lesson, $confirm = 'no')
    {
        if ($confirm == 'yes') {
            $this->getStudentRegistrationService()->deleteForStudentAndLesson($this->getUser(), $lesson);
            return $this->redirectToRoute('student_lesson_details', [
                'id' => $lesson->getId(),
            ]);
        }

        return $this->render('@Student/Lesson/unregister.html.twig', [
            'lesson' => $lesson,
        ]);

    }
}
