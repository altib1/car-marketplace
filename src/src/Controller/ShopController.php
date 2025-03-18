<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ShopType;
use App\Entity\Shop;
use App\Repository\ShopRepository;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;


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
    #[Route('/shop/create', name: 'app_shop_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ShopRepository $shopRepository, FileUploader $fileUploader): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createNotFoundException('You must be logged in to create a shop');
        }

        if ($user->getShop()) {
            throw $this->createAccessDeniedException('You already have a shop');
        }

        $shop = new Shop();
        $shop->setUser($user);
        // Only if you need to force English for dates
        $request->setLocale('en');
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Check if logoImageFileName field exists
                if (!$form->has('logoImageFileName')) {
                    $this->addFlash('error', 'The logo image upload field is not configured properly. Please contact support.');
                    return $this->redirectToRoute('app_shop');
                }

                // Check if logo image is uploaded
                if (!$form->get('logoImageFileName')->getData()) {
                    $this->addFlash('error', 'Please upload a logo image');
                    return $this->redirectToRoute('app_shop_create');
                }

                $shopRepository->add($shop, true, $form, $fileUploader);
                $this->addFlash('success', 'Shop created successfully!');
                return $this->redirectToRoute('app_shop');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while creating the shop');
                return $this->redirectToRoute('app_shop_create');
            }
        }

        return $this->render('shop/create.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/shop/edit/{id}', name: 'app_shop_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, ShopRepository $shopRepository, FileUploader $fileUploader): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createNotFoundException('You must be logged in to edit a shop');
        }

        $shop = $user->getShop();
        if (!$shop || $shop->getId() !== $id) {
            throw $this->createNotFoundException('Shop not found');
        }
        if ($shop->getUser()->getId() !== $user->getId()) {
            return $this->redirectToRoute('app_shop');
        }
        
        // Only if you need to force English for dates
        $request->setLocale('en');
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                // Check for logo image
                if (!$form->get('logoImageFileName')->getData()) {
                    throw new \InvalidArgumentException('Logo image is required');
                }
            
                $shopRepository->edit($shop, true, $form, $fileUploader);
                $this->addFlash('success', 'Shop updated successfully!');
                return $this->redirectToRoute('app_shop');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while updating the shop.');
            }
        }

        return $this->render('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/autoshop/{id}', name: 'app_autoshop_show', methods: ['GET'])]
    public function show(int $id, Request $request, ShopRepository $shopRepository, PaginatorInterface $paginator): Response
    {
        $shop = $shopRepository->find($id);
        
        if (!$shop) {
            throw $this->createNotFoundException('Shop not found');
        }

        $page = $request->query->getInt('page', 1);
        $publications = $shop->getPublications();
        $publications = $paginator->paginate(
            $publications,
            $page,
            9
        );

        return $this->render('shop/show.html.twig', [
            'shop' => $shop,
            'publications' => $publications,
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/shop/delete/{id}', name: 'app_shop_delete', methods: ['POST'])]
    public function delete(int $id, ShopRepository $shopRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createNotFoundException('You must be logged in to delete a shop');
        }

        $shop = $user->getShop();
        if (!$shop || $shop->getId() !== $id) {
            throw $this->createNotFoundException('Shop not found');
        }

        $shopRepository->remove($shop, true);

        return $this->redirectToRoute('app_shop');
    }
}