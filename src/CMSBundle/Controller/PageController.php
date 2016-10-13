<?php

namespace CMSBundle\Controller;

use CMSBundle\Entity\Page;
use CMSBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $pages = $entityManager->getRepository('CMSBundle:Page')->findAll();

        return $this->render('page/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * Creates a new Page entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('CMSBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_show', ['id' => $page->getId()]);
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Page entity.
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('page/show.html.twig', [
            'page'        => $page,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_delete', ['id' => $page->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @param Request $request
     * @param Page    $page
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('CMSBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_edit', ['id' => $page->getId()]);
        }

        return $this->render('page/edit.html.twig', [
            'page'        => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Page entity.
     *
     * @param Request $request
     * @param Page    $page
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index');
    }
}
