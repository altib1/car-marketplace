<?php 

namespace App\Controller;

use App\Service\PublicationSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationSearchController extends AbstractController
{
    #[Route('/publications/search', name: 'app_publications_search')]
    public function search(Request $request, PublicationSearchService $searchService): Response
    {
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

        return $this->render('publication/search.html.twig', [
            'results' => $results,
            'criteria' => $criteria
        ]);
    }
}