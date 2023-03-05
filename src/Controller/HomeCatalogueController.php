<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeCatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'home_catalogue')]
    public function index(): Response
    {
        return $this->render('home_catalogue/index.html.twig', [
            'breadcrumb' => 'Présentation catalogue',
        ]);
    }
}
