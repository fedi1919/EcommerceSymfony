<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{


    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form =$this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()  ){
            $user = $form->getData();

            $password = $encoder->encodePassword($user, $user->getPassword()) ; //coder le mot de passe
            $user->setPassword($password); // affecter le mdp codéé au user
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        
        }

        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}