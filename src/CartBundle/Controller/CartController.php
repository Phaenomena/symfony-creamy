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

        $cart = new Cart();
        $cart->addProduct($product);

        var_dump($cart->getQuantity());

        return $this->render('@Cart/Default/index.html.twig');
    }
}