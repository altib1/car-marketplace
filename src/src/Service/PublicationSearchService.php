<?php 

namespace App\Service;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Elastica\Query\Range;
use Elastica\Query\Term;

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
            $termQuery = new Term(['brand.id' => $criteria['brand']]);
            $boolQuery->addFilter($termQuery);
        }

        // Model filter
        if (!empty($criteria['model'])) {
            $termQuery = new Term(['model.id' => $criteria['model']]);
            $boolQuery->addFilter($termQuery);
        }

        // Motorization type filter
        if (!empty($criteria['motorization_type'])) {
            $termQuery = new Term(['motorizationType.id' => $criteria['motorization_type']]);
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
            }
        }

        // Pagination
        $page = $criteria['page'] ?? 1;
        $perPage = $criteria['per_page'] ?? 10;
        
        return $this->publicationsFinder->findPaginated($query);
    }
}