<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use App\Entity\CategoryShop;
use App\Entity\User;
use App\Entity\Transporteur;
use App\Entity\Order;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategoryShopCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(ProduitsCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(TransporteurCrudController::class)->generateUrl());
        return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());



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
            ->setTitle('Bella');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Category_shop', 'fas fa-list', CategoryShop::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-shopping-cart', Produits::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Transporteur', 'fa fa-truck', Transporteur::class);
        yield MenuItem::linkToCrud('Order', 'fa fa-credit-card', Order::class);
     
     
    }
}
