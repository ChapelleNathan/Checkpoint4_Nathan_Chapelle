<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Posts;
use App\Form\CommentsType;
use App\Form\PostsType;
use App\Repository\CommentsRepository;
use App\Repository\PostsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posts")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/detail/{id}", name="posts_show", methods={"GET", "POST"})
     */
    public function show(
        Posts $post, Request $request, EntityManagerInterface $em, CommentsRepository $commentsRepository
    ): Response {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('posts_show', ['id' => $post->getId()]);
        }
        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="posts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $post->setUpdatedAt(new DateTime());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="posts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="posts_delete", methods={"POST"})
     */
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('posts_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/like", name="posts_like", methods={"GET"})
     */
    public function likes(EntityManagerInterface $em, Posts $post)
    {
        if ($this->getUser()->asLike($post)) {
            $this->getUser()->removeLike($post);
        } else {
            $this->getUser()->addLike($post);
        }
        $em->flush();
        return $this->redirectToRoute('posts_show', [
            'id' => $post->getId(),
        ]);
    }
}
