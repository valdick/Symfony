<?php

namespace Vlad\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VladHelloBundle:Default:index.html.twig', array('name' => $name));
    }
}
