<?php

namespace AppBundle\Controller;

use AppBundle\Entity\category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\categoryController;

class MainController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Response $response = null)
    {
        //echo "dadadad";
        //$response = $this->forward('AppBundle:category:treeAction');
       // print_r($response);

        return $this->render('base.html.twig', array(

        ));
    }
}
