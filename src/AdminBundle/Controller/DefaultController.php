<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        return $this->render('AdminBundle:Default:index.html.twig');
    }
    
    

}
