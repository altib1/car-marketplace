<?php
namespace App\Controller;

use App\Entity\Publication;
use App\Entity\User;
use App\Entity\Wishlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PublicationRepository;
use Knp\Component\Pager\PaginatorInterface;

class WishlistController extends AbstractController
{
    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(PublicationRepository $publicationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();
        $wishlist = $user->getWishlist();

        if ($wishlist) {
            $queryBuilder = $publicationRepository->createQueryBuilder('p')
                ->where('p IN (:publications)')
                ->setParameter('publications', $wishlist->getPublications());

            $page = $request->query->getInt('page', 1);
            $publications = $paginator->paginate(
                $queryBuilder,
                $page,
                6
            );
        } else {
            $publications = [];
        }

        return $this->render('wishlist/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/wishlist/add/{id}', name: 'app_wishlist_add')]
    public function add(Publication $publication, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $wishlist = $user->getWishlist();

        if (!$wishlist) {
            $wishlist = new Wishlist();
            $wishlist->setUser($user);
            $user->setWishlist($wishlist);
        }

        if (!$wishlist->hasPublication($publication)) {
            $wishlist->addPublication($publication);
            $entityManager->persist($wishlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wishlist');
    }

    #[Route('/wishlist/remove/{id}', name: 'app_wishlist_remove')]
    public function remove(Publication $publication, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $wishlist = $user->getWishlist();

        if ($wishlist && $wishlist->hasPublication($publication)) {
            $wishlist->removePublication($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wishlist');
    }
}