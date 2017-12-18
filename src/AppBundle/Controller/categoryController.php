<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\category;
use AppBundle\Entity\Promotion;
use AppBundle\Repository\categoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Role;
use Services;

/**
 * Category controller.

 *
 */
class categoryController extends Controller
{

    /**
     * Lists all category entities.
     *
     * @Route("/category_list", name="cat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:category')->findAll();

        $c = $em->getRepository('AppBundle:category')->getMainCategories();
        var_dump($c);
        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/category_new", name="cat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('AppBundle\Form\categoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('cat_show', array('id' => $category->getId()));
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("category_show/{id}", name="cat_show")
     * @Method("GET")
     */
    public function showAction(category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('category/show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("category_edit/{id}", name="cat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('AppBundle\Form\categoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cat_edit', array('id' => $category->getId()));
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("category_delete/{id}", name="cat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('cat_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cat_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function listMainCategoriesAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:category')->getMainCategories();

        return $this->render(
            'listMainCategories.html.twig',
            array('categories' => $categories)
        );
    }
    /**
     * @Route("/showcategory/{parent}")
     * @Method({"GET", "POST"})
     */
    public function ChildrenOfCategory($parent){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:category')->getChildrenOfCategory($parent);

        $products = $em->getRepository('AppBundle:Product')->getProductsByCategory($parent);
        foreach ($products as $p){
            $promotion = null;

            $promotion[] = $em->getRepository('AppBundle:Promotion')->product($p->getId());
            $promotion[] = $em->getRepository('AppBundle:Promotion')->category($p->getCategoryId());
            arsort($promotion);
            $pr =  $promotion[0];


            $endPrice = ($pr * $p->getPrice())/100;
            $p->setEndPrice($endPrice);
        }

        return $this->render(
            'listChildrenOfCategory.html.twig',
            array('categories' => $categories, 'products' => $products)
        );
    }
}
