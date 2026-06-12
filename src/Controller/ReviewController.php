<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ReviewController extends AbstractController
{
    #[Route('/review/{id}/form', name: 'app_review_form')]
    public function form(Game $game, Request $request, ReviewRepository $reviewRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $review = $reviewRepository->findOneBy([
            'game' => $game,
            'user' => $user,
        ]);

        if (!$review) {
            $review = new Review();
            $review->setGame($game);
            $review->setUser($user);
        }

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();
        }

        return $this->render('review/_form.html.twig', [
            'form' => $form,
            'gameId' => $game->getId(),
            'review' => $review,
        ]);
    }
}
