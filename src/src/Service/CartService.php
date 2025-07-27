<?php

namespace App\Service;

use App\DTO\AddProductToCartDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function addProductToCart(AddProductToCartDTO $dto): Cart
    {
        $cart = new Cart();
        $cartItem = new CartItem();

        $product = $this->productRepository->find($dto->productId);

        $cartItem->setProduct($product);
        $cart->addItem($cartItem);

        $this->entityManager->persist($cart);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $cart;
    }
}
