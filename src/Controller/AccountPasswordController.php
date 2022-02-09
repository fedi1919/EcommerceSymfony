<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    #[Route('/compte/modifierPassword', name: 'account_password')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $old_pwd = $form->get('old_password')->getData();
            
            if ($encoder->isPasswordValid($user, $old_pwd)) { // pour verifier si l'ancien mot de passe est juste
                
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd) ; // coder le nouveau mdp et affecter à une nouvelle variable

                $user->setPassword($password); //affecter le mdp codée au notre user  

                $em = $this->getDoctrine()->getManager();
                $em->flush(); // enregistrer dans la base

                $notification = "Votre mot de passe a bien été mis à jour"; 
            } else {
                $notification = "Votre mot de passe est incorrecte" ;
            }
        }


        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
