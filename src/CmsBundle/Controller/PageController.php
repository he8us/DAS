<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\Page;
use CmsBundle\Form\PageType;
use CmsBundle\Service\PageService;
use CoreBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Page controller.
 *
 */
class PageController extends AbstractCrudController
{
    /**
     * @var string
     */
    protected $datatable = 'cms.datatable.page';

    /**
     * @var string
     */
    protected $templateNamespace = 'CmsBundle:Page:';


    /**
     * Creates a new Page entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getPageService()->save($page);

            return $this->redirectToRoute('cms_page_show', ['id' => $page->getId()]);
        }

        return $this->render('CmsBundle:Page:new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Page entity.
     *
     * @param Page $page
     *
     * @return Response
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('CmsBundle:Page:show.html.twig', [
            'page'        => $page,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cms_page_delete', ['id' => $page->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @param Request $request
     * @param Page    $page
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getPageService()->save($page);

            return $this->redirectToRoute('cms_page_edit', ['id' => $page->getId()]);
        }

        return $this->render('CmsBundle:Page:edit.html.twig', [
            'page'        => $page,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Page entity.
     *
     * @param Request $request
     * @param Page    $page
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getPageService()->delete($page);
        }

        return $this->redirectToRoute('cms_page_index');
    }

    /**
     * @return PageService
     */
    private function getPageService()
    {
        return $this->get('cms.service.page');
    }
}
