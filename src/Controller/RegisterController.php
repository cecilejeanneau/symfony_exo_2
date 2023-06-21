<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
// use App\Form\UserForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register2', name: 'app_home_register2', methods: ['GET', 'POST'])]
    /**
     * Summary of index
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Repository\UserRepository $userRepository
     * @param \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): Response | RedirectResponse 
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // $form->setData($user);

        // $plainPassword = $form->get('plainPassword')->getData();

        
        // $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        // $user->setPassword($hashedPassword);

        // $userRepository->save($user, true);

        // return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if ($plainPassword !== null) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $errors = $validator->validate($user);
            if (count($errors) === 0) {
                $userRepository->save($user, true);

                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }

            // $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            // $user->setPassword($hashedPassword);

            // $userRepository->save($user, true);

            // return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
