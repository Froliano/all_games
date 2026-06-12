<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\WishlistItem;
use App\Repository\WishlistItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class WishlistController extends AbstractController
{
    #[Route('/wishlist/{id}/toggle', name: 'app_game_wishlist_toggle', methods: ['POST'])]
    public function wishlistToggle(Game $game, WishlistItemRepository $wishlistItemRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $wishlist = $wishlistItemRepository->findOneBy([
            'game' => $game,
            'user' => $user,
        ]);

        if ($wishlist) {
            $entityManager->remove($wishlist);
            $wishlist = null;
        } else {
            $wishlist = new WishlistItem();
            $wishlist->setGame($game);
            $wishlist->setUser($user);
            $entityManager->persist($wishlist);
        }

        $entityManager->flush();

        return $this->render('wishlist/_wishlist_button.html.twig', [
            'game' => $game,
            'wishlist' => $wishlist,
        ]);
    }

    #[Route('/wishlist/', name: 'app_wishlist')]
    public function list(WishlistItemRepository $wishlistItemRepository): Response
    {
        $wishlistItems = $wishlistItemRepository->findBy(
            ['user' => $this->getUser()],
            ['createdAt' => 'DESC']
        );

        return $this->render('wishlist/list.html.twig', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
}
