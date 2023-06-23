<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    /**
     * Summary of entityManager
    //  * @var $entityManager EntityManagerInterface
     */
    // private $entityManager;

    
    /**
     * Summary of tokenStorage
    //  * @var $tokenStorage TokenStorageInterface
     */
    // private $tokenStorage;

    // /**
    //  * Summary of user
    //  * @var \Symfony\Component\Security\Core\User\UserInterface $user
    //  */
    // private $user;

    // /**
    //  * Summary of security
    //  * @var $security Security
    //  */
    // private $security;

    /**:
    #[Route('/login', name: 'app_home_login')]
    /**
     * Summary of index
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        // $form = $this->createForm(LoginFormType::class, null, [
        //     'data_class' => User::class,
        // ]);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $formData = $form->getData();
        //     $email = $formData['_email'];
        //     $password = $formData['password'];

        //     // User Authentication
        //     $userRepository = $this->entityManager->getRepository(User::class);
        //     $user = $userRepository->findOneBy(['_email' => $email]);
        //     if (!$user || !$user->verifyPassword($password)) {
        //         throw new AuthenticationException('Invalid login');
        //     }
        //     // $token = new UsernamePasswordToken($this->user, '', ['ROLE_USER'], $this->user->getRoles());
        //     $token = new UsernamePasswordToken($user, $password, ['ROLE_USER']);

        //     $this->tokenStorage->setToken($token);

        //     return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->render('front/home/login/index.html.twig', [
        //     'form' => $form->createView(),
        //     // 'last_username' => $lastUsername,
        //     // 'error' => $error,
        // ]);

        
        return $this->render('front/home/login/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
