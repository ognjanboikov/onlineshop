<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Role;
use AppBundle\Repository\UserRepository;

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
        $t = $em->getRepository('AppBundle:User')->getUsersForPagination();
        $i = 99;
        echo'tererererer';
        return $this->render('users/index.html.twig', array(
            'users' => $users,
            't' => $t,
            'i' => $i,
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
    /**
     * @Route("/profile/edit", name="user_profile_edit")*
     */
    public function editProfileAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($userId);
        $form = $this->createFormBuilder($user)
            ->add('fullName', TextType::class)
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('save', SubmitType::class, array('label' => 'Save'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


             $em = $this->getDoctrine()->getManager();
             $em->persist($user);
             $em->flush();

            return $this->redirectToRoute('user_profile');
        }
        return $this->render('users/editProfile.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("admin/user/{id}/edit", name="admin_user_edit")*
     *
     */
    public function editUserAllFieldsAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(
            array('id' => $id)
        );
        $form = $this->createFormBuilder($user)
            ->add('userName', TextType::class)
            ->add('fullName', TextType::class)
            ->add('cash', TextType::class)
            ->add('usedCash', TextType::class)
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('roles', EntityType::class, array(
                'class' => 'AppBundle:Role',
                'query_builder' => function (RoleRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',

            ))
            ->add('save', SubmitType::class, array('label' => 'Save'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_profile');
        }
        return $this->render('users/editUserAllFields.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
