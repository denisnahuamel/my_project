<?php

namespace Ubicacion\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UbicacionMainBundle:Default:index.html.twig', array('name' => $name));
    }
    public function ubicacionAction()
    {
    	return $this->render('UbicacionMainBundle:Default:ubicacion.html.twig');
    }
}
