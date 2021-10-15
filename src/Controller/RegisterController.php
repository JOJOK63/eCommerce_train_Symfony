<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
//    variable entityManager is the manager entity from doctrine
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager , ) {
        //when i make an object this entity is already in the object , is like a car with many option
        $this->entityManager =$entityManager;
    }


    #[Route('/inscription', 'register')]
//    injection of dependance Request
    public function index(Request $request , UserPasswordEncoderInterface $encoder): Response
    {
        //instanciation of the class User ,because we gonna have a new user
        $user = new User();
        //instanciation du formulaire , on lui injecte la Class register type et les data de user
        $form = $this->createForm(RegisterFormType::class,$user);


        //listen and catch the request
        $form->handleRequest($request);

        //if form is submited and valid do ...
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $encoder->encodePassword($user , $user->getPassword());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        //we get the view and set a table with variable form (and this variable create the view form
        return $this->render('register/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
