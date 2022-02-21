<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Transporteur;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecommerce');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-tie', User::class);
        yield MenuItem::section('Ecommerce');
        yield MenuItem::linkToRoute('Site', 'fas fa-store', 'accueil');
        yield MenuItem::subMenu('Utilisateurs', 'fas fa-user-tie', User::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', User::class)
            ]);
        yield MenuItem::subMenu('Categories', 'fas fa-list', Category::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Category::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Category::class)
            ]);
        yield MenuItem::subMenu('Articles', 'fab fa-elementor', Article::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Article::class)
            ]);
        yield MenuItem::subMenu('Adresses', 'fas fa-address-book', Adresse::class)
            ->setSubItems([
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Adresse::class)
            ]);
        yield MenuItem::subMenu('Transporteurs', 'fas fa-truck', Transporteur::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Transporteur::class)
                    ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Transporteur::class)
            ]);
        yield MenuItem::subMenu('Commandes', 'fas fa-store', Commande::class)
            ->setSubItems([
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Commande::class)
            ]);
    }
}
