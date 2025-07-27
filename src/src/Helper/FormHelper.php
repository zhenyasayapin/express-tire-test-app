<?php

namespace App\Helper;

use Symfony\Component\Form\FormInterface;

class FormHelper
{
    public static function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $field = $error->getOrigin()->getName();
            $errors[$field][] = $error->getMessage();
        }
        return $errors;
    }
}
