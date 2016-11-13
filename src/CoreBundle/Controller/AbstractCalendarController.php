<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Controller;


use Carbon\Carbon;
use CourseBundle\Entity\Lesson;
use StudentBundle\Controller\CalendarController as StudentCalendarController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use TeacherBundle\Controller\CalendarController as TeacherCalendarController;
use TeacherBundle\Service\TeacherService;
use UserBundle\Entity\Student;
use UserBundle\Entity\Teacher;


abstract class AbstractCalendarController extends Controller
{

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function ajaxGetLessonsAction(Request $request, int $id)
    {

        $user = $this->getUserByIdFromCallerClass($id);

        $start = $this->getStartDateFromRequest($request);
        $end = $this->getEndDateFromRequest($request);

        $lessons = $this->getLessonsForInterval($user, $start, $end);
        $lessons = $this->prepareLessonsForAjax($lessons);

        return new JsonResponse($lessons);
    }

    protected function getUserByIdFromCallerClass(int $id)
    {
        switch (static::class) {
            case StudentCalendarController::class:
                return $this->getStudentById($id);

            case TeacherCalendarController::class:
                return $this->getTeacherById($id);
        }

        throw new \Exception("Calling class not handled");
    }

    /**
     * @param int $id
     *
     * @return Student
     */
    private function getStudentById(int $id)
    {
        return $this->getStudentService()->findById($id);
    }

    /**
     * @return StudentService
     */
    protected function getStudentService()
    {
        return $this->get('user.service.student');
    }

    /**
     * @param int $id
     *
     * @return Teacher
     */
    private function getTeacherById(int $id)
    {
        return $this->getTeacherService()->findById($id);
    }

    /**
     * @return TeacherService
     */
    protected function getTeacherService()
    {
        return $this->get('teacher.service.teacher');
    }

    /**
     * @param Request $request
     *
     * @return CalendarController
     */
    protected function getStartDateFromRequest(Request $request)
    {
        $start = Carbon::createFromFormat('Y-m-d', $request->get('start'));
        return $start;
    }

    /**
     * @param Request $request
     *
     * @return CalendarController
     */
    protected function getEndDateFromRequest(Request $request)
    {
        $end = Carbon::createFromFormat('Y-m-d', $request->get('end'));
        return $end;
    }

    /**
     * @param UserInterface $user
     * @param \DateTime     $start
     * @param \DateTime     $end
     *
     * @return array
     */
    abstract protected function getLessonsForInterval(UserInterface $user, \DateTime $start, \DateTime $end);

    /**
     * @param Lesson[] $lessons
     *
     * @return array
     */
    protected function prepareLessonsForAjax(array $lessons = null)
    {

        if ($lessons == null) {
            return [];
        }

        $tmp = [];
        $router = $this->getRouter();

        foreach ($lessons as $lesson) {
            $tmp[] = [
                'id'    => $lesson->getId(),
                'title' => $lesson->getContent()->getName(),
                'start' => $lesson->getStartDate()->format(Carbon::ISO8601),
                'end'   => $lesson->getEndDate()->format(Carbon::ISO8601),
                'url'   => $router->generate($this->getAjaxRoute(), [
                    'id' => $lesson->getId(),
                ]),
                'type'  => $this->getEventType($lesson),
            ];
        }
        return $tmp;
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        $router = $this->get('router');
        return $router;
    }

    private function getAjaxRoute()
    {
        switch (static::class) {
            case StudentCalendarController::class:
                return 'student_lesson_details';

            case TeacherCalendarController::class:
                return 'teacher_lesson_details';
        }

        throw new \Exception('T\'as merdé ton ajax route');
    }

    private function getEventType(Lesson $lesson)
    {

        $now = Carbon::now();

        if ($lesson->getStartDate() < $now && $lesson->getEndDate() > $now) {
            return 'present';
        }

        if ($lesson->getStartDate()->format('Ymd') == $now->format('Ymd')
            || $lesson->getEndDate()->format('Ymd') == $now->format('Ymd')
        ) {
            return 'today';
        }

        if ($lesson->getStartDate() > $now) {
            return 'future';
        }

        if ($lesson->getEndDate() < $now) {
            return 'past';
        }

        throw new \Exception('T\'as merdé ton event type');

    }

}
