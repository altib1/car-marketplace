<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsOfUseController extends AbstractController
{
    #[Route('/terms-of-use', name: 'app_terms_of_use', options: ['sitemap' => ['section' => 'terms-of-service', 'priority' => 0.5]])]
    public function index(): Response
    {
        return $this->render('terms_of_use/index.html.twig');
    }
}