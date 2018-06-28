<?php
/**
 * Created by PhpStorm.
 * User: Charline
 * Date: 25/06/2018
 * Time: 11:44
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{
    /**
     * @Route("/hello", name="sayhello")
     */
    public function sayHelloAction()
    {
        return $this->render('@App/Hello/sayhello.html.twig');
    }

}