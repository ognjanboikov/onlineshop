<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Product controller.
 *
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/product", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/product/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if(!empty($product->getImage())) {
                $file = $product->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
                $product->setImage($fileName);
            }else{

                $goodSubmitted = $form->all();
                $goodSaved = $this->getDoctrine()->getManager()->getRepository("AppBundle:Product")->findOn($goodSubmitted->getId());
                print_r($goodSubmitted->getId());
                $product->setImage($goodSaved->getImages());
            }
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/product/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/product/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $product = $editForm->getData();
            $em = $this->getDoctrine()->getManager();
            //$product->setImage(
           //     new File($this->getParameter('image_directory').'/'.$product->getImage())
         //   );
            //////////////////
            //$this->getDoctrine()->getManager()->flush();
            $file = $product->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );
            $product->setImage($fileName);
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * @Route("/product/{id}/notalledit", name="product_edit_not_all")
     * @Method({"GET", "POST"})
     */
    public function editWithoutImage(Request $request, Product $id){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->findOneBy(
            array('id' => $id)
        );
        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('sku')
            ->add('description')
            ->add('price')
            ->add('isActive')
            ->add('quantity')
            ->add('categoryId', EntityType::class, array(
                'class' => 'AppBundle:category',
                'placeholder' => 'Choose an category',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'required' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'Save'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $product = null;
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $productOld =$this->getDoctrine()->getRepository(Product::class)->findOneBy(
                array('id' => $id)
            );
            $product->setImage($productOld->getImage());
            $em->persist($product);
            $em->flush();
           //return $this->redirectToRoute('product_index');
        }
        return $this->render('product/editWithoutImage.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/product/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
