<?php

namespace App\Controller;

use App\Entity\CarModel;
use App\Entity\MotorizationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use App\Repository\CarModelRepository;
use App\Repository\MotorizationTypeRepository;
use App\Entity\CarBrand;
use App\Service\FileUploader;

#[Route('/publication', name: 'app_publication')]
final class PublicationController extends AbstractController
{
    #[Route(name: '_index', methods: ['GET'])]
    public function index(PublicationRepository $publicationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,  
        FileUploader $fileUploader
        ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $publication = new Publication();
        $publication->setUser($this->getUser());
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the submitted data
            $formData = $form->getData();
            
            // Handle file uploads
            $this->handleFileUploads($form, $publication, $fileUploader);
            
            // Set default values for nullable fields if they're not provided
            $this->setDefaultValues($publication);
            
            // Handle the equipment collection
            $equipmentData = $request->request->all('publication')['equipment'] ?? [];
            if (!empty($equipmentData)) {
                $publication->setEquipment(array_values(array_filter($equipmentData)));
            }

            $entityManager->persist($publication);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Publication $publication): Response
    {
        // Check if current user owns the publication
        if ($publication->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot view this publication.');
        }

        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/remove-image/{image}', name: '_remove_image', methods: ['GET'])]
    public function removeImage(Publication $publication, string $image, EntityManagerInterface $entityManager): Response
    {
        // Check if current user owns the publication
        if ($publication->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot edit this publication.');
        }

        $imageFilenames = $publication->getImageFilenames();
        if (($key = array_search($image, $imageFilenames)) !== false) {
            unset($imageFilenames[$key]);
            $publication->setImageFilenames(array_values($imageFilenames));
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_edit', ['id' => $publication->getId()]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Publication $publication, 
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
        ): Response
    {
        // Check if current user owns the publication
        if ($publication->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot edit this publication.');
        }

        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file uploads
            $this->handleFileUploads($form, $publication, $fileUploader);
            
            // Handle the equipment collection
            $equipmentData = $request->request->all('publication')['equipment'] ?? [];
            if (!empty($equipmentData)) {
                $publication->setEquipment(array_values(array_filter($equipmentData)));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_publication_show', ['id' => $publication->getId()]);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        // Check if current user owns the publication
        if ($publication->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot delete this publication.');
        }

        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }

 #[Route('/models/{brandId}', name: 'get_models', methods: ['GET'])]
    public function getModels(
        int $brandId, 
        CarModelRepository $carModelRepository
    ): JsonResponse {
        $models = $carModelRepository->findBy(['brand' => $brandId]);
        $data = [];

        foreach ($models as $model) {
            $data[] = [
                'id' => $model->getId(),
                'name' => $model->getName(),
            ];
        }

        return new JsonResponse($data);
    }

#[Route('/motorisation-types/{modelId}', name: 'get_motorisation_types', methods: ['GET'])]
    public function getMotorisationTypes(
        int $modelId, 
        MotorizationTypeRepository $motorizationTypeRepository
    ): JsonResponse {
        $motorisationTypes = $motorizationTypeRepository->findBy(['model' => $modelId]);
        $data = [];

        foreach ($motorisationTypes as $motorisationType) {
            $data[] = [
                'id' => $motorisationType->getId(),
                'name' => $motorisationType->getName(),
            ];
        }

        return new JsonResponse($data);
    }

    private function handleFileUploads($form, Publication $publication, FileUploader $fileUploader): void
    {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile[] $imageFiles */
        $imageFiles = $form->get('images')->getData();

        foreach ($imageFiles as $imageFile) {
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $publication->addImageFilename($imageFileName);
            }
        }

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $videoFile */
        $videoFile = $form->get('video')->getData();

        if ($videoFile) {
            $videoFileName = $fileUploader->upload($videoFile);
            $publication->setVideoFilename($videoFileName);
        }
    }

    private function setDefaultValues(Publication $publication): void
    {

        if ($publication->getHasWarranty() === null) {
            $publication->setHasWarranty(false);
        }
        
        if ($publication->getEquipment() === null) {
            $publication->setEquipment([]);
        }
        
        if ($publication->getImageFilenames() === null) {
            $publication->setImageFilenames([]);
        }
    }
}