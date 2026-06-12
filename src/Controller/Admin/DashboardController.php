<?php

namespace App\Controller\Admin;

use App\Controller\Admin\EditorCrudController;
use App\Controller\Admin\GameCrudController;
use App\Controller\Admin\GenreCrudController;
use App\Controller\Admin\ReviewCrudController;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\WishlistItemCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AllGames Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Catalog');
        yield MenuItem::linkTo(GameCrudController::class, 'Games', 'fa fa-gamepad');
        yield MenuItem::linkTo(EditorCrudController::class, 'Editors', 'fa fa-building');
        yield MenuItem::linkTo(GenreCrudController::class, 'Genres', 'fa fa-tags');

        yield MenuItem::section('Community');
        yield MenuItem::linkTo(UserCrudController::class, 'Users', 'fa fa-user');
        yield MenuItem::linkTo(ReviewCrudController::class, 'Reviews', 'fa fa-comment');
        yield MenuItem::linkTo(WishlistItemCrudController::class, 'Wishlist items', 'fa fa-heart');

        yield MenuItem::section();
        yield MenuItem::linkToUrl('Back to site', 'fa fa-arrow-left', '/');
    }
}
