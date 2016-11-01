<?php

namespace CourseBundle\Controller;

use CoreBundle\Controller\AbstractCrudController;
use CourseBundle\Entity\GradeClass;
use CourseBundle\Form\GradeClassType;
use CourseBundle\Service\GradeClassService;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GradeClassController
 *
 * @package CourseBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class GradeClassController extends AbstractCrudController
{
    /**
     * @var string
     */
    protected $datatable = 'courses.datatable.grade_class';

    /**
     * @var string
     */
    protected $templateNamespace = 'CourseBundle:GradeClass:';


    /**
     * Creates a new gradeClass entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $gradeClass = new Gradeclass();
        $form = $this->createForm(GradeClassType::class, $gradeClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeClassService()->save($gradeClass);

            return $this->redirectToRoute('course_gradeclass_show', ['id' => $gradeClass->getId()]);
        }

        return $this->render('CourseBundle:GradeClass:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return GradeClassService
     */
    private function getGradeClassService()
    {
        return $this->get('course.services.gradeclass');
    }

    /**
     * @param GradeClass $gradeClass
     *
     * @return Response
     */
    public function showAction(GradeClass $gradeClass)
    {
        $deleteForm = $this->createDeleteForm($gradeClass);

        return $this->render('CourseBundle:GradeClass:show.html.twig', [
            'gradeClass'  => $gradeClass,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a gradeClass entity.
     *
     * @param GradeClass $gradeClass The gradeClass entity
     *
     * @return Form The form
     */
    private function createDeleteForm(GradeClass $gradeClass)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_gradeclass_delete', ['id' => $gradeClass->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param Request    $request
     * @param GradeClass $gradeClass
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, GradeClass $gradeClass)
    {
        $deleteForm = $this->createDeleteForm($gradeClass);
        $form = $this->createForm(GradeClassType::class, $gradeClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeClassService()->save($gradeClass);

            return $this->redirectToRoute('course_gradeclass_edit', ['id' => $gradeClass->getId()]);
        }

        return $this->render('CourseBundle:GradeClass:edit.html.twig', [
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param Request    $request
     * @param GradeClass $gradeClass
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, GradeClass $gradeClass)
    {
        $form = $this->createDeleteForm($gradeClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getGradeClassService()->delete($gradeClass);
        }

        return $this->redirectToRoute('course_gradeclass_index');
    }

}
