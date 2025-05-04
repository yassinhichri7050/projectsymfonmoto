<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security; 

class PagesController extends AbstractController
{
    #[Route('/pages', name: 'app_pages')]

    public function index(Security $security): Response
    {
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('pages/index.html.twig');
    }
}
