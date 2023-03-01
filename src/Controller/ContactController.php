<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {

        $contactForm = $this->createFormBuilder()
            ->add('name', TextType::class, ['label'=>'Name'])
            ->add('email', EmailType::class, ['label'=>'Email'])
            ->add('subject', TextType::class, ['label'=>'Subject'])
            ->add('message', TextareaType::class, ['label'=>'Message'])
            ->add('Submit', SubmitType::class)
            ->getForm();

        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted()) {
            $inputData = $contactForm->getData();

            $contact = new Contact();
            $contact->setEmail($inputData['email']);
            $contact->setName($inputData['name']);
            $contact->setMessage($inputData['message']);
            $contact->setSubject($inputData['subject']);

            $em  =  $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', "Message Submitted Successfully");


            $this->redirect($this->generateUrl('contact'));

        }
        return $this->render('contact/index.html.twig', [
            'contactform' => $contactForm->createView(),
        ]);
    }
}
