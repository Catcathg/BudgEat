<?php

namespace App\Form;

use App\Entity\Restaurants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RestaurantsFormInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'required' => true, // Champ requis
            ])
            ->add('adresse', null, [
                'required' => true, // Champ requis
            ])
            ->add('ville', null, [
                'required' => true, // Champ requis
            ])
            ->add('codePostal', null, [
                'required' => true, // Champ requis
            ])
            ->add('mail', EmailType::class, [
                'required' => true, // Champ requis
                'label' => 'Adresse e-mail', // Label personnalisé
                
            ])
            ->add('mdp', PasswordType::class, [
                'required' => true, // Champ requis
                'label' => 'Mot de passe',
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class,
        ]);
    }
}
