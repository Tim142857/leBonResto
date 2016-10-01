<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('CoreBundle::Index.html.twig', array('title' => 'Le bon resto'));
    }

}
