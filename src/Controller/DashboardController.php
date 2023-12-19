<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\User;
use App\Entity\Vote;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        if(is_null($this->getUser())) return $this->redirectToRoute('app_login');
        $user  = $this->getUser();
        if(!is_null($user) && in_array("ROLE_ADMIN", $user->getRoles())){
            return $this->render('admin/dashboard.html.twig');
        }
        return $this->render('admin/vote_room.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Election App');
    }

    public function configureMenuItems(): iterable
    {
        $user = $this->getUser();
        if(!is_null($user) && in_array("ROLE_ADMIN", $user->getRoles())){
            yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class);
            yield MenuItem::linkToDashboard('Panel', 'fa fa-home');
            yield MenuItem::linkToCrud('Elections', 'fa-solid fa-check-to-slot', Vote::class);
            yield MenuItem::linkToCrud('Candidatures', 'fa-solid fa-people-line', Candidacy::class);
        }else {
            yield MenuItem::linkToDashboard('Salle de vote', 'fa fa-home');
        }
        //yield MenuItem::linkToCrud('Candidatures', 'fa fa-file-text', Candidacy::class);
    }
}
