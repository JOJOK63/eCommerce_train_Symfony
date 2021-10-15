<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', 'register')]
    public function index(): Response
    {
        //instanciation of the class User ,because we gonna have a new user
        $user = new User();
        //instanciation du formulaire , on lui injecte la Class register type et les data de user
        $form = $this->createForm(RegisterFormType::class,$user);

        //we get the view and set a table with variable form (and this variable create the view form
        return $this->render('register/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
