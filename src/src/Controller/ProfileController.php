<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProfileType;
use App\Form\ChangePasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager, PublicationRepository $publicationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $publication = new Publication();
        $publication->setUser($user);

        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();
            $this->addFlash('success', 'Publication created successfully!');
            return $this->redirectToRoute('app_profile');
        }

        $publications = $publicationRepository->findBy(['user' => $user]);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'publicationForm' => $form->createView(),
            'publications' => $publications,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();
                $this->addFlash('success', 'Profile updated successfully!');
                return $this->redirectToRoute('app_profile');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while updating your profile.');
            }
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/change-password', name: 'app_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Verify current password
            if (!$passwordHasher->isPasswordValid($user, $form->get('currentPassword')->getData())) {
                $this->addFlash('error', 'Current password is incorrect');
                return $this->redirectToRoute('app_change_password');
            }
    
            try {
                $user->setPassword(
                    $passwordHasher->hashPassword($user, $form->get('newPassword')->getData())
                );
                $entityManager->flush();
                $this->addFlash('success', 'Password changed successfully!');
                return $this->redirectToRoute('app_profile');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while changing your password.');
            }
        }
    
        return $this->render('profile/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/delete', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->isCsrfTokenValid('delete-account', $request->request->get('_token'))) {
            throw new AccessDeniedException('Invalid CSRF token.');
        }

        try {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $this->container->get('security.token_storage')->setToken(null);
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Your account has been deleted.');
            return $this->redirectToRoute('app_home');
        } catch (\Exception $e) {
            $this->container->get('logger')->error('Error deleting user account: ' . $e->getMessage());
            $this->addFlash('error', 'An error occurred while deleting your account.');
            return $this->redirectToRoute('app_profile');
        }
    }
}