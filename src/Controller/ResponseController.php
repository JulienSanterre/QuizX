<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Entity\Questions;
use App\Form\ResponseAddType;
use App\Form\ResponseEditType;
use App\Repository\ResponsesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/responses", name="responses_")
*/
class ResponseController extends AbstractController
{
    /**
     * @Route("/list", name="show")
     */
    public function responses(ResponsesRepository $responsesRepository)
    {
        return $this->render('response/responses.html.twig', [
            'responses' => $responsesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list/{id}", name="show_single")
     */
    public function responseId(Responses $responses)
    {
        return $this->render('response/responses_single.html.twig', [
            'responses' => $responses,
        ]);
    }

    /**
     * @Route("/create/{id}", name="create")
     */
    public function createResponse(Request $request, EntityManagerInterface $em, UserRepository $userRepository, Questions $questions)
    {
        if ($questions->getStatus() == false) {
            $currentUserId = $userRepository->find($this->getUser()->getId());
            $responses = new Responses();
            $form = $this->createForm(ResponseAddType::class, $responses);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $responses->setQuestion($questions);
                $responses->setIsBest(false);
                $responses->setStatus(false);
                $responses->setUser($currentUserId);
                $em->persist($responses);
                $em->flush();
                $this->addFlash(
                'success',
                'La question a été créée avec succès.'
            );
            
                return $this->render('response/responses_single.html.twig', [
                'responses' => $responses,
            ]);
            }


            return $this->render('response/response_create.html.twig', [
            'formCreateResponse' => $form->createView(),
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editResponse(Request $request, EntityManagerInterface $em, Responses $responses, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $responses->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
            $form = $this->createForm(ResponseEditType::class, $responses);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $responses->setUpdatedAt(new \DateTime('now'));
                $em->persist($responses);
                $em->flush();
                $this->addFlash(
                'success',
                'La réponse a été modifiée avec succès.'
                );
                return $this->render('response/responses_single.html.twig', [
                    'responses' => $responses,
                ]);
            }

            return $this->render('response/response_edit.html.twig', [
            'formEditResponse' => $form->createView(),
            ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('response/response_edit.html.twig', [
                'responses' => $responses,
            ]);
        }
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteResponse(EntityManagerInterface $em, Responses $responses, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $responses->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
            $this->addFlash(
            'danger',
            'La réponse a bien été supprimée.'
            );

            $em->remove($responses);
            $em->flush();
        
            return $this->redirectToRoute('responses_show');
        }else{
            $this->addFlash(
                'warning',
                'La suppression d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('response/response_delete.html.twig', [
                'responses' => $responses,
            ]);
        }
    }

    /**
     * @Route("/edit/isBest/{id}", name="edit_isBest")
     */
    public function editResponseBest(EntityManagerInterface $em, Responses $responses, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $responses->getQuestion()->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
                if($responses->getIsBest() == false){
                    $responses->getQuestion()->setStatus(true);
                    /* Select all question to reset best for all to false (for dont have 2 best answers)*/
                    $questionResponses = $responses->getQuestion()->getResponse();
                    foreach($questionResponses as $questionResponse){
                        $questionResponse->setIsBest(false);
                    }
                    /* Set the best response */
                    $responses->setIsBest(true);
                    $this->addFlash(
                        'success',
                        'La meilleur réponse est séléctionnée.'
                        );
                }else{
                    $responses->setIsBest(false);
                    $this->addFlash(
                        'warning',
                        'La meilleur réponse est déséléctionnée.'
                        );
                }
                $em->persist($responses);
                $em->flush();
  
                return $this->render('response/responses_single.html.twig', [
                    'responses' => $responses,
                ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('response/responses_single.html.twig', [
                'responses' => $responses,
            ]);
        }
    }

    /**
     * @Route("/edit/status/{id}", name="edit_status")
     */
    public function editResponseStatus(EntityManagerInterface $em, Responses $responses, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $responses->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
                if($responses->getStatus() == false){
                    $responses->setStatus(true);
                    $this->addFlash(
                        'danger',
                        'La réponse est bloquée.'
                        );
                }else{
                    $responses->setStatus(false);
                    $this->addFlash(
                        'success',
                        'La réponse est débloquée.'
                        );
                }
                $em->persist($responses);
                $em->flush();

                return $this->render('response/responses_single.html.twig', [
                    'responses' => $responses,
                ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('response/responses_single.html.twig', [
                'responses' => $responses,
            ]);
        }
    }
}
