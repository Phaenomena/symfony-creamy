<?php

namespace CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="cartIndex")
     */
    public function indexAction()
    {
        $cart = $this->get('session')->get('cart');
        $cart->setTotal(0);

        return $this->render('@Cart/Default/index.html.twig', [
            'cart' => $cart,
        ]);
    }
}
