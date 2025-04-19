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
use App\Repository\CountryRepository;
use App\Repository\RegionRepository;


class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home', options: ['sitemap' => ['section' => 'home', 'priority' => 1]] )]
    public function index(
        Request $request,
        CarBrandRepository $carBrandRepository,
        CarModelRepository $carModelRepository,
        MotorizationTypeRepository $motorizationTypeRepository,
        PublicationSearchService $searchService,
        CountryRepository $countryRepository,
        RegionRepository $sellerLocationRepository
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
            'country' => $request->query->get('country'),
            'seller_location' => $request->query->get('seller_location'),
            'sort' => $request->query->get('sort'),
            'page' => $request->query->getInt('page', 1),
            'per_page' => 10
        ];
    
        $results = $searchService->search($criteria);

        $brands = $carBrandRepository->findAll();
        $models = $carModelRepository->findAll();
        $motorizationTypes = $motorizationTypeRepository->findAll();
        $countries = $countryRepository->findAll();
        $sellerLocations = $sellerLocationRepository->findAll();

        return $this->render('home/index.html.twig', [
            'brands' => $brands,
            'models' => $models,
            'motorizationTypes' => $motorizationTypes,
            'countries' => $countries,
            'sellerLocations' => $sellerLocations,
            'results' => $results,  // results from search service
            'criteria' => $criteria,
        ]);
    }
}