<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createNotFoundException('You must be logged in to view your shop');
        }

        $shop = null;
        $shop = $user->getShop();

        return $this->render('shop/index.html.twig', [
            'shop' => $shop,
            'controller_name' => 'ShopController',
        ]);
    }
}