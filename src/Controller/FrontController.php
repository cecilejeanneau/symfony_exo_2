<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Summary of FrontController
 */
class FrontController extends AbstractController
{
    /**
     * Summary of placeRepository
     * @var $placeRepository PlaceRepository
     */
    private $placeRepository;

    /**
     * Summary of __construct
     * @param \App\Repository\PlaceRepository $placeRepository
     */
    public function __construct(
        PlaceRepository $placeRepository
    )
    {
        $this->placeRepository = $placeRepository;
    }

    #[Route("/search", name: "search")]
    /**
     * Summary of search
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request): Jsonresponse
    {
        $keywords = $request->query->get('keywords');
        $places = $this->placeRepository->searchByKeywords($keywords);

        $searchResults = [];

        foreach ($places as $place) {
            $placePhotos = [];
            
            foreach ($place->getPhotos() as $photo) {
                $placePhotos[] = [
                    'name' => $photo->getName(),
                    'url' => $photo->getUrl(),
                ];
            }
            
            $searchResults[] = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'description' => $place->getDescription(),
                'photos' => $placePhotos,
            ];
        }

        return new JsonResponse($searchResults);
    }

    #[Route("/place/{id}", name: "place_details")]
    /**
     * Summary of details
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function details(int $id): Response
    {
        $place = $this->placeRepository->findPlaceById($id);

        if (!$place) {
            throw $this->createNotFoundException('Place not found');
        }

        return $this->render('front/place/details.html.twig', [
            'place' => $place,
        ]);
    }


    #[Route('/', name: 'app_home')]
    /**
     * Summary of index
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->render('front/home/index.html.twig');
    }
}
