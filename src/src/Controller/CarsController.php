<?php 

namespace App\Controller;

use App\Repository\CarBrandRepository;
use App\Repository\CarModelRepository;
use App\Repository\MotorizationTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PublicationSearchService;
use App\Entity\Publication;


class CarsController extends AbstractController
{
    #[Route('/cars', name: 'app_cars')]
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
            'mileage_min' => $request->query->get('mileage_min'),
            'mileage_max' => $request->query->get('mileage_max'),
            'fuel_type' => $request->query->get('fuel_type'),
            'gearbox' => $request->query->get('gearbox'),
            'condition' => $request->query->get('condition'),
            'has_warranty' => $request->query->get('has_warranty'),
            'sort' => $request->query->get('sort'),
            'page' => $request->query->getInt('page', 1),
            'per_page' => 10
        ];
    
        $results = $searchService->search($criteria);

        $brands = $carBrandRepository->findAll();
        $models = $carModelRepository->findAll();
        $motorizationTypes = $motorizationTypeRepository->findAll();

        return $this->render('cars/index.html.twig', [
            'brands' => $brands,
            'models' => $models,
            'motorizationTypes' => $motorizationTypes,
            'results' => $results,  // results from search service
            'criteria' => $criteria,
        ]);
    }

    #[Route('cars/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Publication $publication): Response
    {
        /** @var \App\Entity\User|null */
        $user = $this->getUser();
        $shop = null;

        if ($user && method_exists($user, 'getShop')) {
            $shop = $user->getShop();
        }
        return $this->render('cars/show.html.twig', [
            'publication' => $publication,
            'shop' => $shop,
        ]);
    }
}
