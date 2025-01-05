<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientBudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('budget', NumberType::class, [
                'label' => 'Votre budget (€)',
                'attr' => [
                    'placeholder' => 'Entrez votre budget',
                    'min' => 0,
                ],
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}