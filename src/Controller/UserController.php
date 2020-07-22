<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use App\Form\UserRegisterType;
use App\Form\UserEditType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
* @Route("/users", name="users_")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="show")
     */
    public function users(UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser()->getId());
        return $this->render('user/users.html.twig', [
            'users' => $userRepository->findAll(),
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * @Route("/list/{id}", name="show_single")
     */
    public function userId(User $user, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser()->getId());
        return $this->render('user/users_single.html.twig', [
            'user' => $user,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function userEdit(Request $request, EntityManagerInterface $em, UserRepository $userRepository)
    {
        // this restrict the current user to only edit his profile , if he change url to edit other profile he always get his profil
        $user = $currentUser = $userRepository->find($this->getUser());
        
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                'Votre compte a été modifié avec succès.'
            );

            return $this->render('user/users_single.html.twig', [
                'user' => $user,
                'currentUser' => $currentUser,
            ]);
        }

        return $this->render('user/user_edit.html.twig', [
            'formEditUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // encode the password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setMail("");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        /*return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);*/
        return $this->render('user/register.html.twig', [
            'formRegister' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
