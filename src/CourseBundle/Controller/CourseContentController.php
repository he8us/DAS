<?php

namespace CourseBundle\Controller;

use CoreBundle\Controller\AbstractCrudController;
use CourseBundle\Entity\CourseContent;
use CourseBundle\Form\CourseContentType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CourseContentController
 *
 * @package CourseBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CourseContentController extends AbstractCrudController
{

    /**
     * @var string
     */
    protected $datatable = 'courses.datatable.content';

    /**
     * @var string
     */
    protected $templateNamespace = 'CourseBundle:CourseContent:';


    /**
     * Creates a new CourseContent entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $courseContent = new CourseContent();
        $form = $this->createForm(CourseContentType::class, $courseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCourseContentService()->save($courseContent);

            return $this->redirectToRoute('course_content_show', ['id' => $courseContent->getId()]);
        }

        return $this->render('CourseBundle:CourseContent:new.html.twig', [
            'courseContent' => $courseContent,
            'form'          => $form->createView(),
        ]);
    }

    private function getCourseContentService()
    {
        return $this->get('course.services.coursecontent');
    }

    /**
     * Finds and displays a CourseContent entity.
     *
     * @param CourseContent $courseContent
     *
     * @return Response
     */
    public function showAction(CourseContent $courseContent)
    {
        $deleteForm = $this->createDeleteForm($courseContent);

        return $this->render('CourseBundle:CourseContent:show.html.twig', [
            'courseContent' => $courseContent,
            'delete_form'   => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a CourseContent entity.
     *
     * @param CourseContent $courseContent The CourseContent entity
     *
     * @return Form The form
     */
    private function createDeleteForm(CourseContent $courseContent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_content_delete', ['id' => $courseContent->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing CourseContent entity.
     *
     * @param Request       $request
     * @param CourseContent $courseContent
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CourseContent $courseContent)
    {
        $deleteForm = $this->createDeleteForm($courseContent);
        $editForm = $this->createForm(CourseContentType::class, $courseContent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courseContent);
            $entityManager->flush();

            return $this->redirectToRoute('course_content_edit', ['id' => $courseContent->getId()]);
        }

        return $this->render('CourseBundle:CourseContent:edit.html.twig', [
            'courseContent' => $courseContent,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a CourseContent entity.
     *
     * @param Request       $request
     * @param CourseContent $courseContent
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, CourseContent $courseContent)
    {
        $form = $this->createDeleteForm($courseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getCourseContentService()->delete($courseContent);
        }

        return $this->redirectToRoute('course_content_index');
    }
}
