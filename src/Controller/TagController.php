<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin/tags", name="admin_")
*/
class TagController extends AbstractController
{
    /**
     * @Route("/list", name="tags_show")
     */
    public function tags(TagsRepository $tagsRepository, UserRepository $userRepository)
    {
        return $this->render('tag/tags.html.twig', [
        'tagsRepository' => $tagsRepository,
        ]);
    }

    /**
     * @Route("/list/{id}", name="tags_show_single")
     */
    public function tagId(Tags $tags, UserRepository $userRepository)
    {
        return $this->render('tag/tags_single.html.twig', [
            'tags' => $tags,
        ]);
    }
}
