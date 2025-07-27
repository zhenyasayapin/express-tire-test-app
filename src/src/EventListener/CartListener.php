<?php

namespace App\EventListener;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class CartListener
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CartRepository $cartRepository,
    )
    {
    }

    #[AsEventListener]
    public function onRequestEvent(RequestEvent $event): void
    {
        $session = $event->getRequest()->getSession();
        $cartId = $session->get('cart_id');

        if (null === $cartId) {
            $cart = new Cart();

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        } else {
            $cart = $this->cartRepository->find($cartId);
        }

        $session->set('cart_id', $cart->getId());

        $event->getRequest()->attributes->set('cart', $cart);
    }
}
