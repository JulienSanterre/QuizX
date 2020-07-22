<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\QuestionAddType;
use App\Form\QuestionEditType;
use App\Repository\QuestionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/questions", name="questions_")
*/
class QuestionController extends AbstractController
{
    /**
     * @Route("/list", name="show")
     */
    public function questions(QuestionsRepository $questionsRepository)
    {
        return $this->render('question/questions.html.twig', [
            'questions' => $questionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list/{id}", name="show_single")
     */
    public function questionId(Questions $questions)
    {
        return $this->render('question/questions_single.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createQuestion(Request $request, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $currentUserId = $userRepository->find($this->getUser()->getId());
        $questions = new Questions();
        $form = $this->createForm(QuestionAddType::class, $questions);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questions->setRestricted(false);
            $questions->setStatus(false);
            $questions->setUser($currentUserId);
            $em->persist($questions);
            $em->flush();
            $this->addFlash(
                'success',
                'La question a été créée avec succès.'
            );
            
            return $this->render('question/questions_single.html.twig', [
                'questions' => $questions,
            ]);
        }

        return $this->render('question/question_create.html.twig', [
            'formCreateQuestion' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editQuestion(Request $request, EntityManagerInterface $em, Questions $questions, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $questions->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
            $form = $this->createForm(QuestionEditType::class, $questions);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $questions->setUpdatedAt(new \DateTime('now'));
                $em->persist($questions);
                $em->flush();
                $this->addFlash(
                'success',
                'La question a été modifiée avec succès.'
                );
                return $this->render('question/questions_single.html.twig', [
                    'questions' => $questions,
                ]);
            }

            return $this->render('question/question_edit.html.twig', [
            'formEditQuestion' => $form->createView(),
            ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('question/questions_single.html.twig', [
                'questions' => $questions,
            ]);
        }
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteQuestion(EntityManagerInterface $em, Questions $questions, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if($currentUser->getId() == $questions->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
            $this->addFlash(
            'danger',
            'La question a bien été supprimée.'
            );

            $em->remove($questions);
            $em->flush();
        
            return $this->redirectToRoute('questions_show');
        }else{
            $this->addFlash(
                'warning',
                'La suppression d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('question/questions_single.html.twig', [
                'questions' => $questions,
            ]);
        }
    }

    /**
     * @Route("/edit/restrict/{id}", name="edit_restrict")
     */
    public function editQuestionRestrict(EntityManagerInterface $em, Questions $questions, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());
        if(in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
                if($questions->getRestricted() == false){
                    $questions->setRestricted(true);
                    $this->addFlash(
                        'danger',
                        'La question est bloquée.'
                        );
                }else{
                    $questions->setRestricted(false);
                    $this->addFlash(
                        'success',
                        'La question est débloquée.'
                        );
                }
                $em->persist($questions);
                $em->flush();
  
                return $this->render('question/questions_single.html.twig', [
                    'questions' => $questions,
                ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('question/questions_single.html.twig', [
                'questions' => $questions,
            ]);
        }
    }

    /**
     * @Route("/edit/status/{id}", name="edit_status")
     */
    public function editQuestionStatus(EntityManagerInterface $em, Questions $questions, UserRepository $userRepository)
    {
        $currentUser = $userRepository->find($this->getUser());

        if($currentUser->getId() == $questions->getUser()->getId() || in_array('ROLE_ADMIN',$currentUser->getRoles()) || in_array('ROLE_MODERATOR',$currentUser->getRoles())) {
                if($questions->getStatus() == false){
                    $questions->setStatus(true);
                    $this->addFlash(
                        'warning',
                        'La question est fermée.'
                        );
                }else{
                    $questions->setStatus(false);
                    $this->addFlash(
                        'success',
                        'La question est ouverte.'
                        );
                }
                $em->persist($questions);
                $em->flush();
                return $this->render('question/questions_single.html.twig', [
                    'questions' => $questions,
                ]);
        }else{
            $this->addFlash(
                'warning',
                'L\'édition d\'un contenu demande d\'en être l\'auteur.'
                );
            return $this->render('question/questions_single.html.twig', [
                'questions' => $questions,
            ]);
        }
    }
}
