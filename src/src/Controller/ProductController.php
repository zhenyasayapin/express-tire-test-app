<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {
    }

    #[Route('/product/type/{id}', name: 'app_product_by_type', methods: ['GET'])]
    public function getProductsByType(Type $type): Response
    {
        return $this->json($this->productRepository->findByType($type->getId()));
    }
}
