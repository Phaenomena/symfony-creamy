<?php
/**
 * Created by PhpStorm.
 * User: Charline
 * Date: 28/06/2018
 * Time: 09:24
 */

namespace CartBundle\Controller;

use CartBundle\Entity\Cart;
use CartBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;


class CartController extends Controller
{
    /**
     * @Route("/view/{id}", name="viewCart", requirements={"id"="\d+"})
     */
    public function viewCartAction($id)
    {
        $repo = $this->getDoctrine()
                     ->getRepository('CartBundle:Product');

        $product = $repo->find($id);
        $session = $this->get('session');

        if (!$session->has('cart')) {
            $session->set('cart', new Cart());
        }

        $session->get('cart')->addProduct($product);

        $this->addFlash('success', 'Le produit a bien été ajouté au panier');

        return $this->redirectToRoute('cartIndex');
    }

    /**
     * @Route("/remove/{id}", name="remCart", requirements={"id"="\d+"})
     */
    public function removeAction($id)
    {
        $repo = $this->getDoctrine()
            ->getRepository('CartBundle:Product');

        $product = $repo->find($id);
        $session = $this->get('session');

        if (!$session->has('cart')) {
            $session->set('cart', new Cart());
        }

        try {
            $session->get('cart')->removeProduct($product);
            $this->addFlash('success', 'Le produit a bien été supprimé du panier');
        } catch (\Exception $e) {
            $this->addFlash('danger', 'Quantité incorrecte');
        }

        return $this->redirectToRoute('cartIndex');
    }

    /**
     * @Route("/clear", name="clearCart")
     */
    public function clearAction()
    {
        $this->get('session')->get('cart')->clearCart();

        $this->addFlash('info', 'Le panier est vide');
        return $this->redirectToRoute('homepage');
    }
}