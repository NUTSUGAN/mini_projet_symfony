<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/comments')]
class AdminCommentController extends AbstractController
{
    #[Route('', name: 'admin_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        // On affiche d'abord les pending (les plus urgents)
        $pending = $commentRepository->findBy(['status' => 'pending'], ['createdAt' => 'DESC']);
        $approved = $commentRepository->findBy(['status' => 'approved'], ['createdAt' => 'DESC']);

        return $this->render('admin_comment/index.html.twig', [
            'pending' => $pending,
            'approved' => $approved,
        ]);
    }

    #[Route('/{id}/approve', name: 'admin_comment_approve', methods: ['POST'])]
    public function approve(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('comment_action_'.$comment->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $comment->setStatus('approved');
        $em->flush();

        $this->addFlash('success', 'Commentaire approuvé.');

        return $this->redirectToRoute('admin_comment_index');
    }

    #[Route('/{id}/reject', name: 'admin_comment_reject', methods: ['POST'])]
    public function reject(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('comment_action_'.$comment->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $comment->setStatus('rejected');
        $em->flush();

        $this->addFlash('success', 'Commentaire rejeté.');

        return $this->redirectToRoute('admin_comment_index');
    }
}
