<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarBrandRepository;
use App\Repository\CarModelRepository;
use App\Repository\MotorizationTypeRepository;
use App\Service\PublicationSearchService;
use Symfony\Component\HttpFoundation\Request;


class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        CarBrandRepository $carBrandRepository,
        CarModelRepository $carModelRepository,
        MotorizationTypeRepository $motorizationTypeRepository,
        PublicationSearchService $searchService,
    ): Response {
        $criteria = [
            'q' => $request->query->get('q'),
            'price_min' => $request->query->get('price_min'),
            'price_max' => $request->query->get('price_max'),
            'year_min' => $request->query->get('year_min'),
            'year_max' => $request->query->get('year_max'),
            'brand' => $request->query->get('brand'),
            'model' => $request->query->get('model'),
            'motorization_type' => $request->query->get('motorization_type'),
            'sort' => $request->query->get('sort'),
            'page' => $request->query->getInt('page', 1),
            'per_page' => 10
        ];
    
        $results = $searchService->search($criteria);

        $brands = $carBrandRepository->findAll();
        $models = $carModelRepository->findAll();
        $motorizationTypes = $motorizationTypeRepository->findAll();

        return $this->render('home/index.html.twig', [
            'brands' => $brands,
            'models' => $models,
            'motorizationTypes' => $motorizationTypes,
            'results' => $results,  // results from search service
            'criteria' => $criteria,
        ]);
    }
}