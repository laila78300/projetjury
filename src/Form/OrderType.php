<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Transporteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options ['user'];
        $builder
      
            ->add('transporteur', EntityType::class, [
                'class' => Transporteur::class,
                'label' => false,
                'required' => true,
                'multiple' => false,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => null
            // Configure your form options here
        ]);
    }
    
}


