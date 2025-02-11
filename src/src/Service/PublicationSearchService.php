<?php 

namespace App\Service;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Elastica\Query\Range;
use Elastica\Query\Term;
use Elastica\Query\Nested;

class PublicationSearchService
{
    public function __construct(
        private PaginatedFinderInterface $publicationsFinder
    ) {}

    public function search(array $criteria)
    {
        $boolQuery = new BoolQuery();
    
        // Search term (searches in title and description)
        if (!empty($criteria['q'])) {
            $multiMatch = new MultiMatch();
            $multiMatch->setFields(['title^3', 'description']);
            $multiMatch->setQuery($criteria['q']);
            $boolQuery->addMust($multiMatch);
        }
    
        // Price range
        if (!empty($criteria['price_min']) || !empty($criteria['price_max'])) {
            $rangeQuery = new Range();
            $range = [];
            if (!empty($criteria['price_min'])) {
                $range['gte'] = $criteria['price_min'];
            }
            if (!empty($criteria['price_max'])) {
                $range['lte'] = $criteria['price_max'];
            }
            $rangeQuery->addField('price', $range);
            $boolQuery->addFilter($rangeQuery);
        }
    
        // Year range
        if (!empty($criteria['year_min']) || !empty($criteria['year_max'])) {
            $rangeQuery = new Range();
            $range = [];
            if (!empty($criteria['year_min'])) {
                $range['gte'] = $criteria['year_min'];
            }
            if (!empty($criteria['year_max'])) {
                $range['lte'] = $criteria['year_max'];
            }
            $rangeQuery->addField('year', $range);
            $boolQuery->addFilter($rangeQuery);
        }
    
        // Brand filter
        if (!empty($criteria['brand'])) {
            $nestedQuery = new Nested();
            $nestedQuery->setPath('brand');
            $termQuery = new Term(['brand.id' => $criteria['brand']]);
            $nestedQuery->setQuery($termQuery);
            $boolQuery->addFilter($nestedQuery);
        }
    
        // Model filter
        if (!empty($criteria['model'])) {
            $nestedQuery = new Nested();
            $nestedQuery->setPath('model');
            $termQuery = new Term(['model.id' => $criteria['model']]);
            $nestedQuery->setQuery($termQuery);
            $boolQuery->addFilter($nestedQuery);
        }
    
        // Motorization type filter
        if (!empty($criteria['motorization_type'])) {
            $nestedQuery = new Nested();
            $nestedQuery->setPath('motorizationType');
            $termQuery = new Term(['motorizationType.id' => $criteria['motorization_type']]);
            $nestedQuery->setQuery($termQuery);
            $boolQuery->addFilter($nestedQuery);
        }

        // seller location filter
        if (!empty($criteria['seller_location'])) {
            $nestedQuery = new Nested();
            $nestedQuery->setPath('sellerLocation');
            $termQuery = new Term(['sellerLocation.id' => $criteria['seller_location']]);
            $nestedQuery->setQuery($termQuery);
            $boolQuery->addFilter($nestedQuery);
        }

        // country filter
        if (!empty($criteria['country'])) {
            $nestedQuery = new Nested();
            $nestedQuery->setPath('country');
            $termQuery = new Term(['country.id' => $criteria['country']]);
            $nestedQuery->setQuery($termQuery);
            $boolQuery->addFilter($nestedQuery);
        }

        // Mileage range
        if (!empty($criteria['mileage_min']) || !empty($criteria['mileage_max'])) {
            $rangeQuery = new Range();
            $range = [];
            if (!empty($criteria['mileage_min'])) {
            $range['gte'] = $criteria['mileage_min'];
            }
            if (!empty($criteria['mileage_max'])) {
            $range['lte'] = $criteria['mileage_max'];
            }
            $rangeQuery->addField('mileage', $range);
            $boolQuery->addFilter($rangeQuery);
        }

        // Fuel type filter
        if (!empty($criteria['fuel_type'])) {
            $termQuery = new Term(['fuelType' => $criteria['fuel_type']]);
            $boolQuery->addFilter($termQuery);
        }

        // Gearbox filter
        if (!empty($criteria['gearbox'])) {
            $termQuery = new Term(['gearbox' => $criteria['gearbox']]);
            $boolQuery->addFilter($termQuery);
        }

        // Condition filter
        if (!empty($criteria['condition'])) {
            $termQuery = new Term(['condition' => $criteria['condition']]);
            $boolQuery->addFilter($termQuery);
        }

        // Warranty filter
        if (!empty($criteria['has_warranty'])) {
            $termQuery = new Term(['hasWarranty' => true]);
            $boolQuery->addFilter($termQuery);
        }

        // import filter
        if (!empty($criteria['is_import'])) {
            $termQuery = new Term(['isImport' => true]);
            $boolQuery->addFilter($termQuery);
        }

        $query = new Query($boolQuery);
        // Add sorting
        if (!empty($criteria['sort'])) {
            switch ($criteria['sort']) {
                case 'price_asc':
                    $query->addSort(['price' => ['order' => 'asc']]);
                    break;
                case 'price_desc':
                    $query->addSort(['price' => ['order' => 'desc']]);
                    break;
                case 'year_desc':
                    $query->addSort(['year' => ['order' => 'desc']]);
                    break;
                case 'year_asc':
                    $query->addSort(['year' => ['order' => 'asc']]);
                    break;
                case 'mileage_desc':
                    $query->addSort(['mileage' => ['order' => 'desc']]);
                    break;
                case 'mileage_asc':
                    $query->addSort(['mileage' => ['order' => 'asc']]);
                    break;
                
            }
        }
    
        // Pagination
        $page = $criteria['page'] ?? 1;
        $perPage = $criteria['per_page'] ?? 10;
    
        // Get the results from the finder
        $paginatedResults = $this->publicationsFinder->findPaginated($query);
        $paginatedResults->setCurrentPage($page);
        $paginatedResults->setMaxPerPage($perPage);
    
        // Access the current page results
        return [
            'results' => $paginatedResults->getCurrentPageResults(),
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($paginatedResults->getNbResults() / $perPage),
                'total_results' => $paginatedResults->getNbResults(),
                'previous_page' => $page > 1 ? $page - 1 : null,
                'next_page' => $page < ceil($paginatedResults->getNbResults() / $perPage) ? $page + 1 : null,
            ]
        ];
    }
    
}