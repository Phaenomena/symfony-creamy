<?php
/**
 * Created by PhpStorm.
 * User: Charline
 * Date: 25/06/2018
 * Time: 14:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $req)
    {
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
                    ->add('email', EmailType::class, ['attr' => ['placeholder' => 'xyz@exemple.com']])
                    ->add('firstname', TextType::class, ['attr' => ['placeholder' => 'John']])
                    ->add('lastname', TextType::class, ['attr' => ['placeholder' => 'Doe']])
                    ->add('title', TextType::class, ['attr' => ['placeholder' => 'Titre du message']])
                    ->add('message', TextareaType::class)
                    ->add('send', SubmitType::class, array('label' => 'Envoyer'))
                    ->getForm();

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Votre message a été envoyé');
            //$this->addFlash('danger', 'Formulaire incomplet');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}