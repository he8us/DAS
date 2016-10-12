<?php

namespace CourseBundle\Controller;

use CourseBundle\Entity\CourseContent;
use CourseBundle\Form\CourseContentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CourseContent controller.
 *
 */
class CourseContentController extends Controller
{
    /**
     * Lists all CourseContent entities.
     *
     */
    public function indexAction()
    {
        $datatable = $this->get("courses.datatable.content");
        $datatable->buildDatatable();

        return $this->render('CourseBundle:coursecontent:index.html.twig', [
            'datatable' => $datatable,
        ]);
    }

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
        $form = $this->createForm('CourseBundle\Form\CourseContentType', $courseContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($courseContent);
            $em->flush();

            return $this->redirectToRoute('course_content_show', ['id' => $courseContent->getId()]);
        }

        return $this->render('CourseBundle:coursecontent:new.html.twig', [
            'courseContent' => $courseContent,
            'form'          => $form->createView(),
        ]);
    }

    /**
     *
     */
    public function resultsAction()
    {
        $datatable = $this->get('courses.datatable.content');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
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

        return $this->render('CourseBundle:coursecontent:show.html.twig', [
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($courseContent);
            $em->flush();

            return $this->redirectToRoute('course_content_edit', ['id' => $courseContent->getId()]);
        }

        return $this->render('CourseBundle:coursecontent:edit.html.twig', [
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
            $em = $this->getDoctrine()->getManager();
            $em->remove($courseContent);
            $em->flush();
        }

        return $this->redirectToRoute('course_content_index');
    }
}
