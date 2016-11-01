<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use CoreBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Student;
use UserBundle\Form\ImportStudentsType;
use UserBundle\Form\StudentType;
use UserBundle\Services\StudentService;

/**
 * Class StudentController
 *
 * @package UserBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class StudentController extends AbstractCrudController
{

    const ROLE_STUDENT = 'ROLE_STUDENT';
    protected $datatable = 'user.datatable.students';
    protected $templateNamespace = 'UserBundle:Student:';

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {

        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $student->setBarcode($this->getRandomString());

            $this->getStudentService()->save($student);

            return $this->redirectToRoute("user_student_index");
        }
        return $this->render('UserBundle:Student:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function getRandomString()
    {
        return $this->get("core.service.random_string_service")->generateRandomString();
    }

    /**
     * @return StudentService
     */
    private function getStudentService()
    {
        return $this->get('user.service.student');
    }

    /**
     * @return Response
     */
    public function importAction()
    {
        $form = $this->createForm(ImportStudentsType::class);


        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: implement
        }

        return $this->render('UserBundle:Student:import.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @param Student $student
     *
     * @return Response
     */
    public function showAction(Student $student)
    {
        $deleteForm = $this->createDeleteForm($student);

        return $this->render('UserBundle:Student:show.html.twig', [
            'student'     => $student,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a student entity.
     *
     * @param Student $student The student entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Student $student)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_student_delete', ['id' => $student->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing student entity.
     *
     * @param Request $request
     * @param Student $student
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Student $student)
    {
        $deleteForm = $this->createDeleteForm($student);
        $editForm = $this->createForm(StudentType::class, $student);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getStudentService()->save($student);

            return $this->redirectToRoute('user_student_index', ['id' => $student->getId()]);
        }

        return $this->render('UserBundle:Student:edit.html.twig', [
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a student entity.
     *
     * @param Request $request
     * @param Student $student
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Student $student)
    {
        $form = $this->createDeleteForm($student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($student);
            $em->flush($student);
        }

        return $this->redirectToRoute('user_student_index');
    }
}
