<?php

namespace App\Form;

use App\DTO\RemoveProductFromCartDTO;
use App\Validator\ProductExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class RemoveProductFromCartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productId', IntegerType::class, [
                'label' => 'Product ID',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Type(type: 'integer'),
                    new Positive(),
                    new ProductExists(),
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RemoveProductFromCartDTO::class,
            'csrf_protection' => false, // Disable CSRF protection for API endpoints
        ]);
    }
}
