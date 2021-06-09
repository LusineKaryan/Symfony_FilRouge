<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Auteur;
use App\Entity\Produit;
use App\Controller\Admin\UserCrudController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();

        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony FilRouge');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-tags', User::class);
        yield MenuItem::section('Les oeuvres');
            yield MenuItem::linkToCrud('Auteurs', 'fas fa-tags', Auteur::class);
            yield MenuItem::linkToCrud('Produits', 'fas fa-tags', Produit::class);
            yield MenuItem::linkToCrud('Genres', 'fas fa-tags', Genre::class);       
    }
}
