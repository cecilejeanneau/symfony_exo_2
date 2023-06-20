<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Summary of FrontController
 */
class FrontController extends AbstractController
{
    /**
     * Summary of entityManager
     * @var 
     */
    private $entityManager;

    /**
     * Summary of __construct
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

        $entityManager = $this->entityManager;
        $query = $entityManager->createQuery(
            'SELECT p.id, p.name, p.description, ph.name, ph.url FROM App\Entity\Place p LEFT JOIN p.photos ph
            WHERE p.name LIKE :keywords
            OR p.description LIKE :keywords
            OR ph.name LIKE :keywords'
        )->setParameter('keywords', '%'.$keywords.'%');

        $lieux = $query->getResult();

        $serializedLieux = [];
        foreach ($lieux as $lieu) {
            $serializedLieux[] = [
                'id' => $lieu['id'],
                'name' => $lieu['name'],
                'description' => $lieu['description'],
                'photo' => [
                    'name' => $lieu['name'],
                    'url' => $lieu['url'],
                ],
            ];
        }

        return new JsonResponse($serializedLieux);
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
