<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Role;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $roleFromDB = $this->getDoctrine()
                ->getRepository(Role::class)
                ->getFirst();
            $user->setRoles($roleFromDB);
            $cash = 20.00;
            $user->setCash($cash);
            $user->setUsedCash(0);
            $user->setRegisterDate(new \DateTime());
            $password = $passwordEncoder->encodePassword($user,$user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->redirectToRoute("cat_index");
        }
        return $this->render('users/register.html.twig',
            array('form' => $form->createView()));
    }
    /**
     * @Route("/admin/userslist", name="list_users")*
     */
    public function listAllUsersAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('users/index.html.twig', array(
            'users' => $users,
        ));
    }
    /**
     * @Route("/profile", name="user_profile")*
     */
    public function userProfileAction(){
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);
        return $this->render('users/profile.html.twig', array(
            'user' => $user,
        ));
    }
}
