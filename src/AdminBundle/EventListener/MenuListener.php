<?php

namespace AdminBundle\EventListener;

use Tleroch\AdminBundle\Model\Menu;
use Tleroch\AdminBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class MenuListener {

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item)
        {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $items = array(
            new Menu('menu-1', 'Section', ''),
            new Menu('sub-menu-1', 'Menu 1', ''),
            new Menu('menu-2', 'Déconnexion', 'tlr_admin_logOut', array(), 'glyphicon glyphicon-log-out')
        );

        return $items;
    }
}