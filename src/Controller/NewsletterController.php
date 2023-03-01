<?php

namespace App\Controller;

use App\Entity\NewsLetter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $newsletter = new NewsLetter();
            $newsletter->setEmail($email);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('home'));
    }
}
