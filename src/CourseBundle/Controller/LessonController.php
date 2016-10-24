<?php

namespace CourseBundle\Controller;

use CoreBundle\Controller\AbstractCrudController;
use CourseBundle\Entity\Lesson;
use CourseBundle\Form\LessonType;
use CourseBundle\Service\LessonService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lesson controller.
 *
 */
class LessonController extends AbstractCrudController
{

    /**
     * @var string
     */
    protected $datatable = 'courses.datatable.lesson';

    /**
     * @var string
     */
    protected $templateNamespace = 'CourseBundle:Lesson:';


    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getLessonService()->save($lesson);

            return $this->redirectToRoute('course_lesson_show', ['id' => $lesson->getId()]);
        }

        return $this->render('CourseBundle:Lesson:new.html.twig', [
            'lesson' => $lesson,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @return LessonService
     */
    private function getLessonService()
    {
        return $this->get('course.services.lesson');
    }

    /**
     * Finds and displays a lesson entity.
     *
     * @param Lesson $lesson
     *
     * @return Response
     */
    public function showAction(Lesson $lesson)
    {
        $deleteForm = $this->createDeleteForm($lesson);

        return $this->render('CourseBundle:Lesson:show.html.twig', [
            'lesson'      => $lesson,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a lesson entity.
     *
     * @param Lesson $lesson The lesson entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lesson $lesson)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_lesson_delete', ['id' => $lesson->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing lesson entity.
     *
     * @param Request $request
     * @param Lesson  $lesson
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Lesson $lesson)
    {
        $deleteForm = $this->createDeleteForm($lesson);
        $editForm = $this->createForm('CourseBundle\Form\LessonType', $lesson);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_lesson_edit', ['id' => $lesson->getId()]);
        }

        return $this->render('CourseBundle:Lesson:edit.html.twig', [
            'lesson'      => $lesson,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a lesson entity.
     *
     * @param Request $request
     * @param Lesson  $lesson
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Lesson $lesson)
    {
        $form = $this->createDeleteForm($lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getLessonService()->delete($lesson);
        }

        return $this->redirectToRoute('course_lesson_index');
    }
}
