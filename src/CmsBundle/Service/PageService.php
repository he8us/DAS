<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CmsBundle\Service;


use CmsBundle\Entity\Page;
use CoreBundle\Service\AbstractEntityService;

class PageService extends AbstractEntityService
{
    protected $entityClass = Page::class;


    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getHomepage($slug)
    {
        return $this->getRepository()->getHomepage($slug);
    }
}
