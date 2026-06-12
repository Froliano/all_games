<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\WishlistItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/game/list', name: 'app_game_list')]
    public function list(GameRepository $gameRepository): Response
    {
        return $this->render('game/list.html.twig', [
            'games' => $gameRepository->findBy([], ['releaseDate' => 'DESC']),
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(Game $game, WishlistItemRepository $wishlistItemRepository): Response
    {
        $wishlist = null;
        $user = $this->getUser();

        if ($user) {
            $wishlist = $wishlistItemRepository->findOneBy([
                'game' => $game,
                'user' => $user,
            ]);
        }

        return $this->render('game/show.html.twig', [
            'game' => $game,
            'wishlist' => $wishlist,
        ]);
    }
}
