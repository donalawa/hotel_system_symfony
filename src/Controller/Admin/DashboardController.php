<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Contact;
use App\Entity\HotelContact;
use App\Entity\NewsLetter;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         return $this->redirect($adminUrlGenerator->setController(RoomCrudController::class)->generateUrl());

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
            ->setTitle('Staymate Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Rooms', 'fa fa-home');
        yield MenuItem::section('Others');
        yield MenuItem::linkToCrud('Bookings', 'fas fa-list', Booking::class);
         yield MenuItem::linkToCrud('Review', 'fas fa-list', Review::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-list', Contact::class);
        yield MenuItem::linkToCrud('Hotel Info', 'fas fa-list', HotelContact::class);
        yield MenuItem::linkToCrud('News Letter', 'fas fa-list', NewsLetter::class);
//        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
    }
}
