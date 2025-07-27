<?php

namespace App\Controller;

use App\DTO\AddProductToCartDTO;
use App\Form\AddProductToCartFormType;
use App\Helper\FormHelper;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
    )
    {
    }

    #[Route('/cart', name: 'app_cart_add_item', methods: ['POST'])]
    public function addItem(Request $request, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(AddProductToCartFormType::class);

        $form->submit($request->getPayload()->all());

        if (!$form->isValid()) {
            return $this->json(['errors' => FormHelper::getFormErrors($form)], Response::HTTP_BAD_REQUEST);
        }

        /** @var AddProductToCartDTO $formDTO */
        $formDTO = $form->getData();

        return $this->json($this->cartService->addProductToCart($formDTO));
    }
}
