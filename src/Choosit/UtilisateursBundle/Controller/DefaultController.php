<?php

namespace Choosit\UtilisateursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChoositUtilisateursBundle:Default:index.html.twig');
    }
}
