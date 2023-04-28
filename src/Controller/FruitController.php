<?php
// src/Controller/FruitController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FruitRepository;

class FruitController extends AbstractController
{
    /**
     * @Route("/api/fruits", methods={"GET"})
     */
    public function list(Request $request, FruitRepository $fruitRepository): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $fruits = $fruitRepository->getPaginatedFruits($page, $limit);

        $data = [
            'fruits' => $fruits,
            'page' => $page,
            'limit' => $limit,
        ];

        return $this->json($data);
    }
}


