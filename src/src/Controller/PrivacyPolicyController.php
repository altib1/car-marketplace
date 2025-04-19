<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PrivacyPolicyController extends AbstractController
{
    #[Route('/privacy-policy', name: 'app_privacy_policy', options: ['sitemap' => ['section' => 'privacy-policy', 'priority' => 0.5]])]
    public function index(): Response
    {
        return $this->render('privacy_policy/index.html.twig', [
            'controller_name' => 'PrivacyPolicyController',
            'page_title' => 'Privacy Policy',
        ]);
    }
}