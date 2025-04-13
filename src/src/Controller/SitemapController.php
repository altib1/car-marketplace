<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Shop;
use App\Repository\PublicationRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    private PublicationRepository $publicationRepository;
    private ShopRepository $shopRepository;
    private array $supportedLocales;

    public function __construct(
        PublicationRepository $publicationRepository,
        ShopRepository $shopRepository,
        array $supportedLocales = ['en', 'sq']
    ) {
        $this->publicationRepository = $publicationRepository;
        $this->shopRepository = $shopRepository;
        $this->supportedLocales = $supportedLocales;
    }

    #[Route('/sitemap.xml', name: 'sitemap', defaults: ["_format" => "xml"])]
    public function index(): Response
    {
        $urls = [];
        $currentDate = (new \DateTime())->format('c');

        $staticPages = [
            'app_home' => ['changefreq' => 'daily', 'priority' => '1.0'],
            'app_publications_search' => ['changefreq' => 'hourly', 'priority' => '0.9'],
            'app_contact' => ['changefreq' => 'monthly', 'priority' => '0.5'],
            'app_about' => ['changefreq' => 'monthly', 'priority' => '0.5'],
            'app_terms_of_use' => ['changefreq' => 'monthly', 'priority' => '0.3'],
            'app_privacy_policy' => ['changefreq' => 'monthly', 'priority' => '0.3'],
        ];

        foreach ($staticPages as $route => $settings) {
            $baseUrl = $this->generateUrl($route, [], UrlGeneratorInterface::ABSOLUTE_URL);
            $hreflangs = $this->generateHreflangs($route);

            $urls[] = [
                'loc' => $baseUrl,
                'lastmod' => $currentDate,
                'changefreq' => $settings['changefreq'],
                'priority' => $settings['priority'],
                'hreflangs' => $hreflangs
            ];
        }

        $publications = $this->publicationRepository->findAll();

        foreach ($publications as $publication) {
            if (
                $publication->getSaleStatus() !== null &&
                $publication->getSaleStatus()->isSold()
            ) {
                continue;
            }

            $baseUrl = $this->generateUrl(
                'app_car_show',
                ['id' => $publication->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $hreflangs = $this->generateHreflangs('app_car_show', ['id' => $publication->getId()]);
            $title = $this->generatePublicationTitle($publication);

            $urls[] = [
                'loc' => $baseUrl,
                'lastmod' => $this->getLastModDate($publication),
                'changefreq' => 'daily',
                'priority' => '0.8',
                'hreflangs' => $hreflangs,
                'images' => $this->getPublicationImages($publication),
                'title' => $title
            ];
        }

        $shops = $this->shopRepository->findAll();

        foreach ($shops as $shop) {
            $baseUrl = $this->generateUrl(
                'app_autoshop_show',
                ['id' => $shop->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $hreflangs = $this->generateHreflangs('app_shop', ['id' => $shop->getId()]);

            $urls[] = [
                'loc' => $baseUrl,
                'lastmod' => $shop->getCreationDate()->format('c'),
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'hreflangs' => $hreflangs,
                'images' => $this->getShopImages($shop),
                'title' => $shop->getName()
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', ['urls' => $urls]),
            Response::HTTP_OK
        );
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }

    private function getLastModDate($entity): string
    {
        return (new \DateTime())->format('c');
    }

    private function generateHreflangs(string $routeName, array $routeParams = []): array
    {
        $hreflangs = [];

        foreach ($this->supportedLocales as $locale) {
            $params = array_merge($routeParams, ['_locale' => $locale]);
            $hreflangs[] = [
                'href' => $this->generateUrl($routeName, $params, UrlGeneratorInterface::ABSOLUTE_URL),
                'hreflang' => $locale
            ];
        }

        $hreflangs[] = [
            'href' => $this->generateUrl($routeName, $routeParams, UrlGeneratorInterface::ABSOLUTE_URL),
            'hreflang' => 'x-default'
        ];

        return $hreflangs;
    }

    private function getPublicationImages(Publication $publication): array
    {
        $images = [];

        if ($publication->getImageFilenames() && is_array($publication->getImageFilenames())) {
            foreach ($publication->getImageFilenames() as $filename) {
                $imageUrl = $this->getImageUrl($filename);

                if (!empty($imageUrl)) {
                    $images[] = [
                        'loc' => $imageUrl,
                        'title' => $this->generatePublicationTitle($publication)
                    ];
                    return $images;
                }
            }
        }

        return $images;
    }

    private function getShopImages(Shop $shop): array
    {
        $images = [];

        if ($shop->getLogoImageFileName()) {
            $logoUrl = $this->getImageUrl($shop->getLogoImageFileName());
            if (!empty($logoUrl)) {
                $images[] = [
                    'loc' => $logoUrl,
                    'title' => $shop->getName() . ' - Logo'
                ];
            }
        }

        if ($shop->getBackgroundImageFileName()) {
            $bgUrl = $this->getImageUrl($shop->getBackgroundImageFileName());
            if (!empty($bgUrl)) {
                $images[] = [
                    'loc' => $bgUrl,
                    'title' => $shop->getName() . ' - Background'
                ];
            }
        }

        return $images;
    }

    private function getImageUrl(string $filename): string
    {
        $baseUrl = $this->generateUrl('app_home', [], UrlGeneratorInterface::ABSOLUTE_URL);
        return rtrim($baseUrl, '/') . '/uploads/images/' . ltrim($filename, '/');
    }

    private function generatePublicationTitle(Publication $publication): string
    {
        $title = '';

        if ($publication->getBrand() && $publication->getModel()) {
            $title = $publication->getBrand()->getName() . ' ' . $publication->getModel()->getName();

            if ($publication->getYear()) {
                $title .= ' ' . $publication->getYear();
            }

            if ($publication->getMotorizationType()) {
                $title .= ' ' . $publication->getMotorizationType()->getName();
            }
        }

        if (empty($title)) {
            $title = 'Car Publication #' . $publication->getId();
        }

        return $title;
    }
}
