<?php

namespace App\Service;

use App\DTO\AddProductToCartDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductRepository $productRepository,
        private readonly RequestStack $requestStack
    )
    {
    }

    public function addProductToCart(AddProductToCartDTO $dto): Cart
    {
        $cart = $this->getCart();
        $cartItem = new CartItem();

        $product = $this->productRepository->find($dto->productId);

        $cartItem->setProduct($product);
        $cart->addItem($cartItem);

        $this->entityManager->persist($cart);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return $cart;
    }

    public function getCart(): Cart
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request->attributes->get('cart');
    }
}
