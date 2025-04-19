<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about', options: ['sitemap' => ['section' => 'about', 'priority' => 0.8]])]
    public function index(): Response
    {
        return $this->render('about/index.html.twig');
    }
}