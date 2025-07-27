<?php

namespace App\Validator;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ProductExistsValidator extends ConstraintValidator
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value) {
            return;
        }

        $product = $this->productRepository->find($value);

        if (!$product) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ id }}', $value)
                ->addViolation();
        }
    }
}
