<?php

namespace AdminBundle\EventListener;

use Tleroch\AdminBundle\Model\Menu;
use Tleroch\AdminBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class MenuListener {

    public function onSetupMenu(SidebarMenuEvent $event) {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request) {
        $items = array(
            new Menu('menu-1', 'Catégories', 'admin_categories', array(), 'glyphicon glyphicon-edit'),
            new Menu('menu-2', 'Produits', 'tleroch_news_admin', array(), 'glyphicon glyphicon-edit'),
            new Menu('menu-3', 'Menus', 'tleroch_news_admin', array(), 'glyphicon glyphicon-edit'),
            new Menu('menu-4', 'News', 'tleroch_news_admin', array(), 'glyphicon glyphicon-tags'),
            new Menu('menu-5', 'Déconnexion', 'tlr_admin_logOut', array(), 'glyphicon glyphicon-log-out')
        );

        return $items;
    }

}
