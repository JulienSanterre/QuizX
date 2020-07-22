<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tags;

use App\Form\TagAddType;
use App\Form\TagEditType;
use App\Form\AdminUserEditType;

use App\Repository\TagsRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin", name="admin_")
*/
class AdminController extends AbstractController
{
    /**
     * @Route("/users", name="show_users")
     */
    public function adminUsers(UserRepository $userRepository)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/users/{id}", name="show_users_single")
     */
    public function adminUserId(User $user)
    {
        return $this->render('admin/users_single.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/edit/{id}", name="edit_users")
     */
    public function adminEditUsers(Request $request, EntityManagerInterface $em, User $user, UserRepository $userRepository)
    {
        $form = $this->createForm(AdminUserEditType::class, $user);

        $username = $user->getUsername();
        $requestSelector = $request->request->get('admin_user_edit');
        $requestSelector["username"] = $username;
        $request->request->set('admin_user_edit', $requestSelector);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($username);
            $em->persist($user);
            $em->flush();
            $this->addFlash(
            'success',
            'Les données de l utilisateur modifiées avec succès.'
        );
            return $this->render('admin/users_single.html.twig', [
            'user' => $user,
        ]);
        }

        return $this->render('admin/user_edit.html.twig', [
        'formEditUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tags", name="show_tags")
     */
    public function adminTags(TagsRepository $tagsRepository)
    {
        return $this->render('admin/tags.html.twig', [
            'tags' => $tagsRepository->findAll() ,
        ]);
    }

    /**
     * @Route("/tags/{id}", name="show_tags_single")
     */
    public function adminTagId(Tags $tags)
    {
        return $this->render('admin/tags_single.html.twig', [
            'tag' => $tags,
        ]);
    }

    /**
     * @Route("/tags/create/new", name="create_tags")
     */
    public function adminCreateTags(Request $request, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $tags = new Tags();
        $form = $this->createForm(TagAddType::class, $tags);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tags);
            $em->flush();
            $this->addFlash(
                'success',
                'Le Tag a été ajouté avec succès.'
            );
        }

        return $this->render('admin/tag_create.html.twig', [
            'formAddTag' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tags/edit/{id}", name="edit_tags")
     */
    public function adminEditTags(Request $request, EntityManagerInterface $em, Tags $tags)
    {
        $form = $this->createForm(TagEditType::class, $tags);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tags);
            $em->flush();
            $this->addFlash(
                'success',
                'Le Tag a été modifié avec succès.'
            );
        }

        return $this->render('admin/tag_edit.html.twig', [
            'formEditTag' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tags/delete/{id}", name="delete_tags")
     */
    public function adminDeleteTags(EntityManagerInterface $em, Tags $tags)
    {
        $this->addFlash(
            'danger',
            'Le Tag a bien été supprimé.'
        );

        $em->remove($tags);
        $em->flush();
        
        return $this->redirectToRoute('admin_show_tags');
    }
}
