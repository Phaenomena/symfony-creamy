<?php
/**
 * Created by PhpStorm.
 * User: Charline
 * Date: 27/06/2018
 * Time: 09:15
 */

namespace CartBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product/add", name="addProduct")
     */
    public function addProductAction(Request $request)
    {
        $form = $this->createForm('CartBundle\Form\Type\ProductType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');
            return $this->redirectToRoute('addProduct');
        }

        return $this->render('@Cart/AddProduct/addproduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}