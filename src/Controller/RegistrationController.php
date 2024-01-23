<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserDetails;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $userDetails = new UserDetails();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                   
                )
            );
            
            $userDetails->setName($form->get('name')->getData());
            $userDetails->setSurname($form->get('surname')->getData());

            // Powiązywanie UserDetails z User
            $user->setIdUserDetails($userDetails);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('/views/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    public function account(): Response
{
    $user = $this->getUser();
    $userDetails = $user->getIdUserDetails();

    return $this->render('some_template.html.twig', [
        'userDetails' => $userDetails,
    ]);
}
}
