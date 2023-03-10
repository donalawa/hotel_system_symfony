<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(Request $request, UserPasswordEncoderInterface $passEncoder): Response
    {

        $regForm = $this->createFormBuilder()
            ->add('username', TextType::class,  ['label'=>'Name'])
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'required'=>true,
                'first_options'=> ['label' => 'Password'],
                'second_options'=>['label' => 'Repeat Password'],
            ])
            ->add('register', SubmitType::class)->getForm();

        $regForm->handleRequest($request);

        if($regForm->isSubmitted()) {
            $inputData = $regForm->getData();

            $user = new User();
            $user->setUsername($inputData['username']);
            $user->setPassword(
                $passEncoder->encodePassword($user, $inputData['password'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->redirect($this->generateUrl('app_login'));
        }



        return $this->render('registration/index.html.twig', [
            'regform'=>$regForm->createView()
        ]);
    }
}
