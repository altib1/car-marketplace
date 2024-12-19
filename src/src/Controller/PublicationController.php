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

#[Route('/publication')]
final class PublicationController extends AbstractController
{
    #[Route(name: 'app_publication_index', methods: ['GET'])]
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_publication_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,  
        FileUploader $fileUploader
        ): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the selected model and motorization type
            $carBrand = $entityManager->getRepository(CarBrand::class)->find($form->get('brand')->getData());
            $carModel = $entityManager->getRepository(CarModel::class)->find($form->get('model')->getData());
            $motorizationType = $entityManager->getRepository(MotorizationType::class)->find($form->get('motorizationType')->getData());
            
            // If you want to associate these with the publication
            $publication->setBrand($carBrand);
            $publication->setModel($carModel);
            $publication->setMotorizationType($motorizationType);
            
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $newFilename = $fileUploader->upload($brochureFile);
                $publication->setBrochureFilename($newFilename);
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

    #[Route('/{id}', name: 'app_publication_show', methods: ['GET'])]
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
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
}