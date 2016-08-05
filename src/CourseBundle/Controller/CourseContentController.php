<?php

namespace CourseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CourseBundle\Entity\CourseContent;
use CourseBundle\Form\CourseContentType;

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
        $em = $this->getDoctrine()->getManager();

        $courseContents = $em->getRepository('CourseBundle:CourseContent')->findAll();

        return $this->render('coursecontent/index.html.twig', array(
            'courseContents' => $courseContents,
        ));
    }

    /**
     * Creates a new CourseContent entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

            return $this->redirectToRoute('course_content_show', array('id' => $courseContent->getId()));
        }

        return $this->render('coursecontent/new.html.twig', array(
            'courseContent' => $courseContent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CourseContent entity.
     *
     * @param CourseContent $courseContent
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(CourseContent $courseContent)
    {
        $deleteForm = $this->createDeleteForm($courseContent);

        return $this->render('coursecontent/show.html.twig', array(
            'courseContent' => $courseContent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CourseContent entity.
     *
     * @param Request       $request
     * @param CourseContent $courseContent
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CourseContent $courseContent)
    {
        $deleteForm = $this->createDeleteForm($courseContent);
        $editForm = $this->createForm('CourseBundle\Form\CourseContentType', $courseContent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($courseContent);
            $em->flush();

            return $this->redirectToRoute('course_content_edit', array('id' => $courseContent->getId()));
        }

        return $this->render('coursecontent/edit.html.twig', array(
            'courseContent' => $courseContent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CourseContent entity.
     *
     * @param Request       $request
     * @param CourseContent $courseContent
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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

    /**
     * Creates a form to delete a CourseContent entity.
     *
     * @param CourseContent $courseContent The CourseContent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CourseContent $courseContent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_content_delete', array('id' => $courseContent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
