<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CMSBundle\Menu;


class MenuChain
{

    /**
     * @var MenuItemMap
     */
    private $menuItems;


    public function __construct()
    {
        $this->menuItems = new MenuItemMap();
    }

    /**
     * @param MenuItemSequence $menuItemSequence
     *
     * @param                  $position
     *
     * @return $this
     */
    public function addMenuItems(MenuItemSequence $menuItemSequence, $position)
    {
        foreach ($menuItemSequence as $menuItem) {
            $this->addMenuItem($menuItem, $position);
        }
        return $this;
    }

    /**
     * @param MenuItem $menuItem
     * @param          $position
     *
     * @return $this
     */
    protected function addMenuItem(MenuItem $menuItem, $position)
    {

        if (null === $this->menuItems->get($position)) {
            $this->menuItems->set($position, new MenuItemSequence());
        }

        $this->menuItems->get($position)->add($menuItem);

        return $this;
    }

    /**
     * @param string $position
     *
     * @return array|null
     */
    public function getMenuItems(string $position)
    {
        if (array_key_exists($position, $this->menuItems)) {
            return $this->menuItems[$position];
        }
    }
}
