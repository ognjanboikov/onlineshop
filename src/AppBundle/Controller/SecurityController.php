<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")

     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $utils)
    {
        return $this->render('security/login.html.twig',
            array('error' => $utils->getLastAuthenticationError()));
    }

    /**
     * @Route("/logout")
     */
    public function logout(){

    }
}
