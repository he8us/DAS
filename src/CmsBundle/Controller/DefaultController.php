<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CmsBundle\Controller;

use CmsBundle\Service\PageService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 *
 * @package CmsBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('CmsBundle:Default:index.html.twig', [
            'page' => $this->getHomepage()
        ]);
    }

    public function pageAction(Page $page)
    {
        return $this->render('CmsBundle:Default:see.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @return Page
     */
    private function getHomepage()
    {
        return $this->getPageService()->getHomepage('accueil');
    }

    /**
     * @return PageService
     */
    private function getPageService()
    {
        return $this->get('cms.service.page');
    }
}
