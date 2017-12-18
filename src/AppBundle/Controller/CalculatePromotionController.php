<?php
/**
 * Created by PhpStorm.
 * User: ogi
 * Date: 17.12.2017 г.
 * Time: 14:18
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\PromotionRepository;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\Promotion;
use AppBundle\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CalculatePromotionController extends Controller
{


}