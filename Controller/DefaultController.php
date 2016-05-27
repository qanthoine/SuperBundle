<?php

namespace SuperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SuperBundle:Default:index.html.twig');
    }
}
