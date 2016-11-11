<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace TeacherBundle\Controller;


use Carbon\Carbon;
use CourseBundle\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TeacherBundle\Service\TeacherService;
use UserBundle\Entity\Teacher;

class CalendarController extends Controller
{
    public function ajaxGetLessonsAction(Request $request, Teacher $teacher)
    {

        $start = Carbon::createFromFormat('Y-m-d', $request->get('start'));
        $end = Carbon::createFromFormat('Y-m-d', $request->get('end'));
        $lessons = $this->getLessonsForInterval($teacher, $start, $end);

        $tmp = [];

        $router = $this->get('router');


        /** @var Lesson $lesson */
        foreach ($lessons as $lesson){
            $end = Carbon::createFromTimestamp($lesson->getDate()->getTimestamp());
            $tmp[] = [
                'id' => $lesson->getId(),
                'title' => $lesson->getContent()->getName(),
                'start' => $lesson->getDate()->format(Carbon::ISO8601),
                'end' => $end->addHour()->format(Carbon::ISO8601),
                'url' => $router->generate('teacher_lesson_details', [
                    'id' => $lesson->getId(),
                ])
            ];
        }

        return new JsonResponse($tmp);
    }

    /**
     * @return TeacherService
     */
    private function getTeacherService()
    {
        return $this->get('teacher.service.teacher');
    }


    /**
     * @param Teacher   $teacher
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    private function getLessonsForInterval(Teacher $teacher, \DateTime $start, \DateTime $end)
    {
        return $this->getTeacherService()->getCoursesForInterval($teacher, $start, $end);
    }

}
