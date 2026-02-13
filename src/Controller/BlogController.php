<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    // Home : /
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $latestPosts = $postRepository->findBy([], ['publishedAt' => 'DESC'], 6);

        $featured = $latestPosts[0] ?? null;
        $posts = array_slice($latestPosts, 1);

        return $this->render('blog/index.html.twig', [
            'featured' => $featured,
            'posts' => $posts,
        ]);
    }

    // ✅ Liste publique : /posts (TOUT LE MONDE)
    #[Route('/posts', name: 'blog_posts', methods: ['GET'])]
    public function posts(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    // Détail + commentaires : /posts/{id}
    #[Route('/posts/{id}', name: 'blog_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Envoi commentaire : seulement si user connecté
        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('ROLE_USER');

            $comment->setAuthor($this->getUser());
            $comment->setPost($post);
            $comment->setStatus('pending');

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Commentaire envoyé (en attente de validation).');

            return $this->redirectToRoute('blog_show', ['id' => $post->getId()]);
        }

        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView(),
        ]);
    }
}
