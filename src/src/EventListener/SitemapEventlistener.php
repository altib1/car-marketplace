<?php 

namespace App\EventListener;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Repository\PublicationRepository;
use Symfony\Component\Routing\Annotation\Route;


#[AsEventListener(event: SitemapPopulateEvent::class, method: 'onSitemapPopulate')]
class SitemapEventlistener
{
    private PublicationRepository $publicationRepository;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        PublicationRepository $publicationRepository,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->publicationRepository = $publicationRepository;
        $this->urlGenerator = $urlGenerator;
    }

    public function onSitemapPopulate(SitemapPopulateEvent $event): void
    {
        // Add static routes
        $urlContainer = $event->getUrlContainer();
        
        // Add cars index page
        $url = new UrlConcrete(
            $this->urlGenerator->generate('app_cars', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );
        $urlContainer->addUrl($url, 'cars');
        
        // Add individual car pages
        $publications = $this->publicationRepository->findAll();
        
        foreach ($publications as $publication) {
            $url = new UrlConcrete(
                $this->urlGenerator->generate('app_car_show', ['id' => $publication->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
            );
            $urlContainer->addUrl($url, 'car-items');
        }
    }

}