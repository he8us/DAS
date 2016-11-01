<?php

namespace CourseBundle\Controller;

use CoreBundle\Controller\AbstractCrudController;
use CourseBundle\Entity\Grade;
use CourseBundle\Form\GradeType;
use CourseBundle\Service\GradeService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Grade controller.
 *
 */
class GradeController extends AbstractCrudController
{
    /**
     * @var string
     */
    protected $datatable = 'courses.datatable.grade';

    /**
     * @var string
     */
    protected $templateNamespace = 'CourseBundle:Grade:';

    /**
     * Creates a new grade entity.
     *
     */
    public function newAction(Request $request)
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeService()->save($grade);

            return $this->redirectToRoute('course_grade_show', ['id' => $grade->getId()]);
        }

        return $this->render('CourseBundle:Grade:new.html.twig', [
            'grade' => $grade,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @return GradeService
     */
    private function getGradeService()
    {
        return $this->get('course.services.grade');
    }

    /**
     * Finds and displays a grade entity.
     *
     * @param Grade $grade
     *
     * @return Response
     */
    public function showAction(Grade $grade)
    {
        $deleteForm = $this->createDeleteForm($grade);

        return $this->render('CourseBundle:Grade:show.html.twig', [
            'grade'       => $grade,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a grade entity.
     *
     * @param Grade $grade The grade entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grade $grade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_grade_delete', ['id' => $grade->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing grade entity.
     *
     * @param Request $request
     * @param Grade   $grade
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Grade $grade)
    {
        $deleteForm = $this->createDeleteForm($grade);
        $form = $this->createForm(GradeType::class, $grade);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeService()->save($grade);

            return $this->redirectToRoute('course_grade_edit', ['id' => $grade->getId()]);
        }

        return $this->render('CourseBundle:Grade:edit.html.twig', [
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a grade entity.
     *
     * @param Request $request
     * @param Grade   $grade
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Grade $grade)
    {
        $form = $this->createDeleteForm($grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeService()->delete($grade);
        }

        return $this->redirectToRoute('course_grade_index');
    }
}
